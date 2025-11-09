<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function login()
    {
        // If already logged in, redirect to dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url('dashboard'));
        }

        $data = [
            'title' => 'Login - Weather Tracker',
            'validation' => \Config\Services::validation()
        ];

        return view('auth/login', $data);
    }

    public function loginProcess()
    {
        $session = session();
        $userModel = new UserModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Validation
        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => 'required|min_length[3]',
            'password' => 'required|min_length[6]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Check user credentials
        $user = $userModel->getUserByUsername($username);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                // Set session data
                $sessionData = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role'],
                    'isLoggedIn' => true,
                ];
                $session->set($sessionData);

                return redirect()->to(base_url('dashboard'))->with('success', 'Login successful!');
            } else {
                return redirect()->back()->withInput()->with('error', 'Invalid password');
            }
        } else {
            return redirect()->back()->withInput()->with('error', 'User not found');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'))->with('success', 'Logged out successfully');
    }

    public function register()
    {
        // Only accessible to admin
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to(base_url('login'))->with('error', 'Access denied');
        }

        $data = [
            'title' => 'Register User - Weather Tracker',
            'validation' => \Config\Services::validation()
        ];

        return view('auth/register', $data);
    }

    public function registerProcess()
    {
        // Only admin can register new users
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to(base_url('login'))->with('error', 'Access denied');
        }

        $userModel = new UserModel();

        $data = [
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password'),
            'role' => $this->request->getPost('role'),
        ];

        if ($userModel->save($data)) {
            return redirect()->to(base_url('users'))->with('success', 'User registered successfully');
        } else {
            return redirect()->back()->withInput()->with('errors', $userModel->errors());
        }
    }
}
