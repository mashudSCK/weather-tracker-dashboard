<?php

namespace App\Controllers;

use App\Models\CityModel;
use CodeIgniter\Controller;

class CityController extends Controller
{
    protected $cityModel;

    public function __construct()
    {
        $this->cityModel = new CityModel();
    }

    public function index()
    {
        // Only admin can access
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to(base_url('dashboard'))->with('error', 'Access denied');
        }

        $data = [
            'title' => 'Manage Cities - Weather Tracker',
            'cities' => $this->cityModel->orderBy('city_name', 'ASC')->findAll(),
        ];

        return view('cities/index', $data);
    }

    public function create()
    {
        // Only admin can access
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to(base_url('dashboard'))->with('error', 'Access denied');
        }

        $data = [
            'title' => 'Add City - Weather Tracker',
            'validation' => \Config\Services::validation()
        ];

        return view('cities/create', $data);
    }

    public function store()
    {
        // Only admin can access
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to(base_url('dashboard'))->with('error', 'Access denied');
        }

        $data = [
            'city_name' => $this->request->getPost('city_name'),
            'country_code' => $this->request->getPost('country_code'),
        ];

        if ($this->cityModel->save($data)) {
            return redirect()->to(base_url('cities'))->with('success', 'City added successfully');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->cityModel->errors());
        }
    }

    public function edit($id = null)
    {
        // Only admin can access
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to(base_url('dashboard'))->with('error', 'Access denied');
        }

        $city = $this->cityModel->find($id);

        if (!$city) {
            return redirect()->to(base_url('cities'))->with('error', 'City not found');
        }

        $data = [
            'title' => 'Edit City - Weather Tracker',
            'city' => $city,
            'validation' => \Config\Services::validation()
        ];

        return view('cities/edit', $data);
    }

    public function update($id = null)
    {
        // Only admin can access
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to(base_url('dashboard'))->with('error', 'Access denied');
        }

        $data = [
            'city_name' => $this->request->getPost('city_name'),
            'country_code' => $this->request->getPost('country_code'),
        ];

        if ($this->cityModel->update($id, $data)) {
            return redirect()->to(base_url('cities'))->with('success', 'City updated successfully');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->cityModel->errors());
        }
    }

    public function delete($id = null)
    {
        // Only admin can access
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to(base_url('dashboard'))->with('error', 'Access denied');
        }

        if ($this->cityModel->delete($id)) {
            return redirect()->to(base_url('cities'))->with('success', 'City deleted successfully');
        } else {
            return redirect()->to(base_url('cities'))->with('error', 'Failed to delete city');
        }
    }
}
