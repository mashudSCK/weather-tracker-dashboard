<?php

namespace App\Controllers;

use App\Models\CityModel;
use App\Models\WeatherModel;
use App\Models\UserModel;
use CodeIgniter\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'))->with('error', 'Please login first');
        }

        $cityModel = new CityModel();
        $weatherModel = new WeatherModel();
        $userModel = new UserModel();

        $data = [
            'title' => 'Dashboard - Weather Tracker',
            'totalCities' => $cityModel->countAllResults(),
            'totalUsers' => $userModel->countAllResults(),
            'totalWeatherLogs' => $weatherModel->countAllResults(),
            'recentWeather' => $weatherModel->select('weather_logs.*, cities.city_name, cities.country_code')
                                           ->join('cities', 'cities.id = weather_logs.city_id')
                                           ->orderBy('weather_logs.fetched_at', 'DESC')
                                           ->limit(5)
                                           ->findAll(),
        ];

        return view('dashboard/index', $data);
    }
}
