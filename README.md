# 🌦️ Weather Tracker Dashboard# CodeIgniter 4 Application Starter



A comprehensive full-stack weather tracking and management system built with **CodeIgniter 4**, **MySQL**, and **Bootstrap 5**. This application demonstrates system integration, modular MVC architecture, role-based authentication, CRUD operations, and real-time weather API integration with OpenWeatherMap.## What is CodeIgniter?



---CodeIgniter is a PHP full-stack web framework that is light, fast, flexible and secure.

More information can be found at the [official site](https://codeigniter.com).

## 📋 Table of Contents

This repository holds a composer-installable app starter.

- [Features](#features)It has been built from the

- [System Requirements](#system-requirements)[development repository](https://github.com/codeigniter4/CodeIgniter4).

- [Installation Guide](#installation-guide)

- [Configuration](#configuration)More information about the plans for version 4 can be found in [CodeIgniter 4](https://forum.codeigniter.com/forumdisplay.php?fid=28) on the forums.

- [Database Setup](#database-setup)

- [Usage](#usage)You can read the [user guide](https://codeigniter.com/user_guide/)

- [Project Structure](#project-structure)corresponding to the latest version of the framework.

- [API Integration](#api-integration)

- [Security Features](#security-features)## Installation & updates

- [Technical Documentation](#technical-documentation)

`composer create-project codeigniter4/appstarter` then `composer update` whenever

---there is a new release of the framework.



## ✨ FeaturesWhen updating, check the release notes to see if there are any changes you might need to apply

to your `app` folder. The affected files can be copied or merged from

### 🔐 Authentication & Authorization`vendor/codeigniter4/framework/app`.

- **Role-Based Access Control**: Admin and User roles with different permissions

- **Secure Login/Logout**: Session-based authentication## Setup

- **Password Hashing**: Using PHP's `password_hash()` and `password_verify()`

- **CSRF Protection**: Built-in CodeIgniter CSRF protectionCopy `env` to `.env` and tailor for your app, specifically the baseURL

and any database settings.

### 👥 User Management (Admin Only)

- Create, Read, Update, Delete (CRUD) users## Important Change with index.php

- Assign roles (Admin/User)

- Prevent self-deletion`index.php` is no longer in the root of the project! It has been moved inside the *public* folder,

- Input validation and error handlingfor better security and separation of components.



### 🌍 City Management (Admin Only)This means that you should configure your web server to "point" to your project's *public* folder, and

- Add new cities with country codesnot to the project root. A better practice would be to configure a virtual host to point there. A poor practice would be to point your web server to the project root and expect to enter *public/...*, as the rest of your logic and the

- Edit existing city informationframework are exposed.

- Delete cities (cascading delete for weather logs)

- View all cities in sortable table**Please** read the user guide for a better explanation of how CI4 works!



### 🌤️ Weather Features## Repository Management

- **Real-time Weather Data**: Fetch current weather from OpenWeatherMap API

- **Weather Caching**: Store weather data in database for quick accessWe use GitHub issues, in our main repository, to track **BUGS** and to track approved **DEVELOPMENT** work packages.

- **Weather History**: Track temperature trends over timeWe use our [forum](http://forum.codeigniter.com) to provide SUPPORT and to discuss

- **Interactive Charts**: Visualize temperature and humidity using Chart.jsFEATURE REQUESTS.

- **Batch Fetch**: Admin can fetch weather for all cities at once

- **Detailed Weather View**: This repository is a "distribution" one, built by our release preparation script.

  - Current temperatureProblems with it can be raised on our forum, or as issues in the main repository.

  - Feels like temperature

  - Humidity percentage## Server Requirements

  - Wind speed

  - Weather condition and descriptionPHP version 8.1 or higher is required, with the following extensions installed:



### 📊 Dashboard- [intl](http://php.net/manual/en/intl.requirements.php)

- Statistics overview (total cities, users, weather logs)- [mbstring](http://php.net/manual/en/mbstring.installation.php)

- Recent weather updates

- Quick action buttons> [!WARNING]

- Role-specific features> - The end of life date for PHP 7.4 was November 28, 2022.

> - The end of life date for PHP 8.0 was November 26, 2023.

### 🎨 User Interface> - If you are still using PHP 7.4 or 8.0, you should upgrade immediately.

- **Responsive Design**: Bootstrap 5 with mobile-first approach> - The end of life date for PHP 8.1 will be December 31, 2025.

- **Modern UI**: Gradient backgrounds, card-based layout

- **Icon Integration**: Bootstrap Icons for visual enhancementAdditionally, make sure that the following extensions are enabled in your PHP:

- **Alert System**: Success/error flash messages

- **Dark Sidebar**: Professional navigation menu- json (enabled by default - don't turn it off)

- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL

---- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library


## 💻 System Requirements

- **PHP**: >= 8.1
- **MySQL**: >= 5.7 or MariaDB >= 10.3
- **Composer**: Latest version
- **XAMPP**: 8.1 or higher (includes Apache, MySQL, PHP)
- **Web Browser**: Modern browser (Chrome, Firefox, Edge, Safari)
- **OpenWeatherMap API Key**: Free tier available at [openweathermap.org](https://openweathermap.org/api)

---

## 🚀 Installation Guide

### Step 1: Install XAMPP
1. Download and install XAMPP from [apachefriends.org](https://www.apachefriends.org/)
2. Start Apache and MySQL services from XAMPP Control Panel

### Step 2: Verify Project Location
```bash
# The project should be in XAMPP htdocs directory
cd c:\xampp\htdocs\WeatherTracker
```

### Step 3: Install Dependencies (If Needed)
```bash
# Install PHP dependencies via Composer
composer install
```

### Step 4: Database Setup

#### Option A: Using phpMyAdmin (Recommended)
1. Open browser and go to `http://localhost/phpmyadmin`
2. Click "Import" tab
3. Choose file: `database.sql` from project root
4. Click "Go" button

#### Option B: Using Migrations
```bash
# Run migrations
php spark migrate

# Run seeders
php spark db:seed UserSeeder
php spark db:seed CitySeeder
```

### Step 5: Configure OpenWeatherMap API
1. Visit [OpenWeatherMap](https://openweathermap.org/api)
2. Sign up for a free account
3. Generate API key
4. Update `weather.apiKey` in `.env` file:
```env
weather.apiKey = YOUR_API_KEY_HERE
```

### Step 6: Access Application
1. Open browser
2. Navigate to: `http://localhost/WeatherTracker/public/`
3. Login with default credentials:
   - **Admin**: username: `admin`, password: `admin123`
   - **User**: username: `user`, password: `user123`

---

## ⚙️ Configuration

The `.env` file is already configured with these settings:

```env
# Environment
CI_ENVIRONMENT = development

# Base URL
app.baseURL = 'http://localhost/WeatherTracker/public/'

# Database Configuration
database.default.hostname = localhost
database.default.database = weather_tracker
database.default.username = root
database.default.password = 

# OpenWeatherMap API Configuration
weather.apiKey = YOUR_OPENWEATHERMAP_API_KEY_HERE
weather.apiURL = https://api.openweathermap.org/data/2.5/weather
```

---

## 🗄️ Database Schema

### Tables

#### `users` Table
```sql
- id (Primary Key, Auto Increment)
- username (VARCHAR 100, Unique)
- password (VARCHAR 255, Hashed)
- role (ENUM: 'admin', 'user')
- created_at (DATETIME)
- updated_at (DATETIME)
```

#### `cities` Table
```sql
- id (Primary Key, Auto Increment)
- city_name (VARCHAR 100)
- country_code (VARCHAR 10)
- created_at (DATETIME)
- updated_at (DATETIME)
```

#### `weather_logs` Table
```sql
- id (Primary Key, Auto Increment)
- city_id (Foreign Key → cities.id)
- temperature (DECIMAL 5,2)
- feels_like (DECIMAL 5,2)
- humidity (INT 3)
- condition (VARCHAR 100)
- description (VARCHAR 255)
- wind_speed (DECIMAL 5,2)
- fetched_at (DATETIME)
- created_at (DATETIME)
```

### Default Data
- **Users**: 
  - Admin: `admin` / `admin123`
  - User: `user` / `user123`
- **Cities**: 8 sample cities (London, New York, Tokyo, Paris, Sydney, Dubai, Singapore, Mumbai)

---

## 📖 Usage

### For Admin Users

1. **Login** with admin credentials (`admin` / `admin123`)
2. **Dashboard**: View statistics and recent weather updates
3. **Manage Cities**:
   - Navigate to "Manage Cities"
   - Add new cities with city name and country code
   - Edit or delete existing cities
4. **Manage Users**:
   - Navigate to "Manage Users"
   - Register new users with roles
   - Edit user information or delete users
5. **Weather**:
   - View all cities' current weather
   - Click "Refresh Data" to fetch latest weather
   - Click "Fetch All Weather" to update all cities at once
   - Click "View Details" to see weather history and charts

### For Regular Users

1. **Login** with user credentials (`user` / `user123`)
2. **Dashboard**: View weather statistics
3. **Weather**:
   - View current weather for all cities
   - Refresh individual city weather
   - View detailed weather information with historical trends
   - See temperature and humidity charts

---

## 📁 Project Structure

```
WeatherTracker/
├── app/
│   ├── Config/
│   │   ├── Routes.php          # Application routing
│   │   └── Filters.php         # Filter configuration
│   ├── Controllers/
│   │   ├── AuthController.php  # Authentication
│   │   ├── UserController.php  # User CRUD
│   │   ├── CityController.php  # City CRUD
│   │   ├── WeatherController.php # Weather API
│   │   └── DashboardController.php # Dashboard
│   ├── Models/
│   │   ├── UserModel.php
│   │   ├── CityModel.php
│   │   └── WeatherModel.php
│   ├── Views/
│   │   ├── layout/main.php
│   │   ├── auth/ (login, register)
│   │   ├── dashboard/
│   │   ├── weather/
│   │   ├── cities/
│   │   └── users/
│   ├── Filters/
│   │   ├── AuthFilter.php
│   │   ├── AdminFilter.php
│   │   └── GuestFilter.php
│   └── Database/
│       ├── Migrations/
│       └── Seeds/
├── public/
│   └── index.php
├── .env
├── database.sql
├── README.md
└── TECHNICAL_REPORT.md
```

---

## 🔌 API Integration

### OpenWeatherMap API

**Endpoint**: `https://api.openweathermap.org/data/2.5/weather`

**Parameters**:
- `q`: City name (e.g., "London")
- `appid`: Your API key
- `units`: metric (for Celsius)

**Example**:
```
https://api.openweathermap.org/data/2.5/weather?q=London&appid=YOUR_KEY&units=metric
```

**Data Cached**:
- Temperature (°C)
- Feels like temperature
- Humidity (%)
- Weather condition
- Description
- Wind speed (m/s)
- Timestamp

---

## 🔒 Security Features

✅ **Password Hashing**: bcrypt algorithm  
✅ **CSRF Protection**: Token-based validation  
✅ **Input Validation**: Server-side validation rules  
✅ **XSS Protection**: Output escaping  
✅ **SQL Injection Prevention**: Query Builder & prepared statements  
✅ **Session Security**: Secure session management  
✅ **Role-Based Access**: Admin and User permissions  
✅ **Authentication Filters**: Route protection  

---

## 📚 Technical Documentation

See [TECHNICAL_REPORT.md](TECHNICAL_REPORT.md) for:
- System Architecture Diagram
- ER Diagram
- Authentication Flow
- API Integration Details
- Security Implementation
- Deployment Guide

---

## 🛠️ Troubleshooting

### Database Connection Error
- Ensure MySQL is running in XAMPP
- Verify credentials in `.env`
- Check database `weather_tracker` exists

### 404 Not Found
- Enable `mod_rewrite` in Apache
- Verify `.htaccess` in `public/` folder
- Check base URL in `.env`

### Weather API Not Working
- Verify API key in `.env`
- Wait a few hours after API key generation
- Check internet connection

### CSRF Token Mismatch
- Clear browser cache
- Ensure forms include `<?= csrf_field() ?>`

---

## 🎯 Demo Script (3-5 minutes)

1. **Login & Authentication** (1 min)
   - Show login page
   - Login as admin
   - Explain role-based access

2. **Weather Features** (2 min)
   - View weather dashboard
   - Fetch fresh data from API
   - Show Chart.js visualization
   - Explain caching mechanism

3. **Admin CRUD Operations** (1-2 min)
   - Add new city
   - Manage users
   - Delete operations

4. **User Role Demo** (30 sec)
   - Login as regular user
   - Show limited access

---

## 📝 License

Open-source project for educational purposes.

---

## 👨‍💻 Credits

**Framework**: CodeIgniter 4  
**UI**: Bootstrap 5  
**Icons**: Bootstrap Icons  
**Charts**: Chart.js  
**Weather API**: OpenWeatherMap  

---

**🌟 Happy Weather Tracking!**
