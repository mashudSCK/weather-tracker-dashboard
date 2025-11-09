<?php

namespace App\Controllers;

use App\Models\CityModel;
use App\Models\WeatherModel;
use CodeIgniter\Controller;

class WeatherController extends Controller
{
    protected $cityModel;
    protected $weatherModel;
    protected $apiKey;
    protected $apiURL;

    public function __construct()
    {
        $this->cityModel = new CityModel();
        $this->weatherModel = new WeatherModel();
        $this->apiKey = getenv('weather.apiKey');
        $this->apiURL = getenv('weather.apiURL');
    }

    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'))->with('error', 'Please login first');
        }

        $cities = $this->cityModel->findAll();
        $weatherData = [];

        foreach ($cities as $city) {
            $latestWeather = $this->weatherModel->getLatestWeatherByCity($city['id']);
            $weatherData[] = [
                'city' => $city,
                'weather' => $latestWeather
            ];
        }

        $data = [
            'title' => 'Weather Dashboard - Weather Tracker',
            'weatherData' => $weatherData,
        ];

        return view('weather/index', $data);
    }

    public function fetch($cityId = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'))->with('error', 'Please login first');
        }

        $city = $this->cityModel->find($cityId);

        if (!$city) {
            return redirect()->to(base_url('weather'))->with('error', 'City not found');
        }

        // Fetch from API
        $weatherData = $this->fetchWeatherFromAPI($city['city_name']);

        if ($weatherData) {
            // Save to database
            $data = [
                'city_id' => $city['id'],
                'temperature' => $weatherData['main']['temp'],
                'feels_like' => $weatherData['main']['feels_like'],
                'humidity' => $weatherData['main']['humidity'],
                'condition' => $weatherData['weather'][0]['main'],
                'description' => $weatherData['weather'][0]['description'],
                'wind_speed' => $weatherData['wind']['speed'],
                'fetched_at' => date('Y-m-d H:i:s'),
            ];

            if ($this->weatherModel->save($data)) {
                return redirect()->to(base_url('weather/view/' . $cityId))->with('success', 'Weather data fetched successfully');
            } else {
                return redirect()->to(base_url('weather'))->with('error', 'Failed to save weather data');
            }
        } else {
            return redirect()->to(base_url('weather'))->with('error', 'Failed to fetch weather data from API');
        }
    }

    public function view($cityId = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'))->with('error', 'Please login first');
        }

        $city = $this->cityModel->find($cityId);

        if (!$city) {
            return redirect()->to(base_url('weather'))->with('error', 'City not found');
        }

        $latestWeather = $this->weatherModel->getLatestWeatherByCity($cityId);
        $weatherHistory = $this->weatherModel->getWeatherHistory($cityId, 20);

        $data = [
            'title' => 'Weather Details - ' . $city['city_name'],
            'city' => $city,
            'weather' => $latestWeather,
            'history' => $weatherHistory,
        ];

        return view('weather/view', $data);
    }

    private function fetchWeatherFromAPI($cityName)
    {
        $client = \Config\Services::curlrequest();

        try {
            $url = $this->apiURL . '?q=' . urlencode($cityName) . '&appid=' . $this->apiKey . '&units=metric';
            
            $response = $client->get($url, [
                'http_errors' => false,
                'timeout' => 10,
            ]);

            if ($response->getStatusCode() == 200) {
                return json_decode($response->getBody(), true);
            } else {
                log_message('error', 'Weather API error: ' . $response->getBody());
                return null;
            }
        } catch (\Exception $e) {
            log_message('error', 'Weather API exception: ' . $e->getMessage());
            return null;
        }
    }

    public function fetchAll()
    {
        // Only admin can fetch all
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to(base_url('dashboard'))->with('error', 'Access denied');
        }

        $cities = $this->cityModel->findAll();
        $successCount = 0;
        $failCount = 0;

        foreach ($cities as $city) {
            $weatherData = $this->fetchWeatherFromAPI($city['city_name']);

            if ($weatherData) {
                $data = [
                    'city_id' => $city['id'],
                    'temperature' => $weatherData['main']['temp'],
                    'feels_like' => $weatherData['main']['feels_like'],
                    'humidity' => $weatherData['main']['humidity'],
                    'condition' => $weatherData['weather'][0]['main'],
                    'description' => $weatherData['weather'][0]['description'],
                    'wind_speed' => $weatherData['wind']['speed'],
                    'fetched_at' => date('Y-m-d H:i:s'),
                ];

                if ($this->weatherModel->save($data)) {
                    $successCount++;
                } else {
                    $failCount++;
                }
            } else {
                $failCount++;
            }
        }

        return redirect()->to(base_url('weather'))->with('success', "Fetched weather for $successCount cities. Failed: $failCount");
    }
}
