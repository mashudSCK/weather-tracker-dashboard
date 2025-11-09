<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Redirect root to login
$routes->get('/', 'AuthController::login');

// Authentication Routes
$routes->group('', ['filter' => 'guest'], function ($routes) {
    $routes->get('login', 'AuthController::login');
    $routes->post('login', 'AuthController::loginProcess');
});

$routes->get('logout', 'AuthController::logout');

// Protected Routes (require authentication)
$routes->group('', ['filter' => 'auth'], function ($routes) {
    // Dashboard
    $routes->get('dashboard', 'DashboardController::index');
    
    // Weather Routes
    $routes->get('weather', 'WeatherController::index');
    $routes->get('weather/fetch/(:num)', 'WeatherController::fetch/$1');
    $routes->get('weather/view/(:num)', 'WeatherController::view/$1');
    $routes->get('weather/fetch-all', 'WeatherController::fetchAll');
    
    // Admin Only Routes
    $routes->group('', ['filter' => 'admin'], function ($routes) {
        // City Management
        $routes->get('cities', 'CityController::index');
        $routes->get('cities/create', 'CityController::create');
        $routes->post('cities/store', 'CityController::store');
        $routes->get('cities/edit/(:num)', 'CityController::edit/$1');
        $routes->post('cities/update/(:num)', 'CityController::update/$1');
        $routes->get('cities/delete/(:num)', 'CityController::delete/$1');
        
        // User Management
        $routes->get('users', 'UserController::index');
        $routes->get('register', 'AuthController::register');
        $routes->post('register', 'AuthController::registerProcess');
        $routes->get('users/edit/(:num)', 'UserController::edit/$1');
        $routes->post('users/update/(:num)', 'UserController::update/$1');
        $routes->get('users/delete/(:num)', 'UserController::delete/$1');
    });
});
