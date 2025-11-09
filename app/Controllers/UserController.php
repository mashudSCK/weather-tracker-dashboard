<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class UserController extends Controller
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Only admin can access
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to(base_url('dashboard'))->with('error', 'Access denied');
        }

        $data = [
            'title' => 'Manage Users - Weather Tracker',
            'users' => $this->userModel->findAll(),
        ];

        return view('users/index', $data);
    }

    public function edit($id = null)
    {
        // Only admin can access
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to(base_url('dashboard'))->with('error', 'Access denied');
        }

        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to(base_url('users'))->with('error', 'User not found');
        }

        $data = [
            'title' => 'Edit User - Weather Tracker',
            'user' => $user,
            'validation' => \Config\Services::validation()
        ];

        return view('users/edit', $data);
    }

    public function update($id = null)
    {
        // Only admin can access
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to(base_url('dashboard'))->with('error', 'Access denied');
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'role' => $this->request->getPost('role'),
        ];

        // Only update password if provided
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = $password;
        }

        if ($this->userModel->update($id, $data)) {
            return redirect()->to(base_url('users'))->with('success', 'User updated successfully');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
        }
    }

    public function delete($id = null)
    {
        // Only admin can access
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to(base_url('dashboard'))->with('error', 'Access denied');
        }

        // Prevent deleting yourself
        if ($id == session()->get('id')) {
            return redirect()->to(base_url('users'))->with('error', 'You cannot delete your own account');
        }

        if ($this->userModel->delete($id)) {
            return redirect()->to(base_url('users'))->with('success', 'User deleted successfully');
        } else {
            return redirect()->to(base_url('users'))->with('error', 'Failed to delete user');
        }
    }
}
