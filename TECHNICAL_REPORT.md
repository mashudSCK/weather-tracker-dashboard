# Weather Tracker Dashboard - Technical Report

## Executive Summary

This document provides comprehensive technical documentation for the Weather Tracker Dashboard, a full-stack web application built with CodeIgniter 4, MySQL, and Bootstrap 5. The system demonstrates enterprise-level web development practices including MVC architecture, RESTful API integration, role-based authentication, and responsive design.

---

## 1. System Overview

### 1.1 Purpose
The Weather Tracker Dashboard is designed to:
- Provide real-time weather information for multiple cities
- Enable administrators to manage cities and users
- Maintain historical weather data for trend analysis
- Demonstrate modern web development best practices

### 1.2 Technology Stack

| Component | Technology | Version |
|-----------|------------|---------|
| Backend Framework | CodeIgniter 4 | 4.6.3 |
| Programming Language | PHP | >= 8.1 |
| Database | MySQL | >= 5.7 |
| Frontend Framework | Bootstrap | 5.3.0 |
| JavaScript Library | Chart.js | Latest |
| Icons | Bootstrap Icons | 1.10.0 |
| Dependency Manager | Composer | Latest |
| Web Server | Apache (XAMPP) | >= 2.4 |
| External API | OpenWeatherMap | v2.5 |

### 1.3 Key Features
- ✅ Role-Based Access Control (Admin & User)
- ✅ CRUD Operations (Cities & Users)
- ✅ Real-time Weather API Integration
- ✅ Weather Data Caching & History
- ✅ Interactive Data Visualization (Chart.js)
- ✅ Responsive Material Design UI
- ✅ Session-Based Authentication
- ✅ CSRF Protection & Input Validation
- ✅ Password Hashing (bcrypt)

---

## 2. System Architecture

### 2.1 MVC Architecture Diagram

```
┌─────────────────────────────────────────────────────────────┐
│                        PRESENTATION LAYER                    │
│  ┌──────────┐  ┌──────────┐  ┌──────────┐  ┌──────────┐   │
│  │  Login   │  │Dashboard │  │ Weather  │  │  Cities  │   │
│  │  View    │  │   View   │  │   View   │  │   View   │   │
│  └──────────┘  └──────────┘  └──────────┘  └──────────┘   │
│                   (Bootstrap 5 + Chart.js)                   │
└─────────────────────────────────────────────────────────────┘
                            ↓ ↑
┌─────────────────────────────────────────────────────────────┐
│                     APPLICATION LAYER                        │
│  ┌──────────────┐  ┌──────────────┐  ┌─────────────────┐  │
│  │    Auth      │  │   Weather    │  │  City/User      │  │
│  │  Controller  │  │  Controller  │  │  Controllers    │  │
│  └──────────────┘  └──────────────┘  └─────────────────┘  │
│                                                              │
│  ┌──────────────────────────────────────────────────────┐  │
│  │             Filters & Middleware Layer                │  │
│  │  - AuthFilter  - AdminFilter  - CSRF Protection      │  │
│  └──────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────┘
                            ↓ ↑
┌─────────────────────────────────────────────────────────────┐
│                        BUSINESS LOGIC                        │
│  ┌──────────────┐  ┌──────────────┐  ┌─────────────────┐  │
│  │    User      │  │    City      │  │    Weather      │  │
│  │    Model     │  │    Model     │  │     Model       │  │
│  └──────────────┘  └──────────────┘  └─────────────────┘  │
└─────────────────────────────────────────────────────────────┘
                            ↓ ↑
┌─────────────────────────────────────────────────────────────┐
│                       DATA ACCESS LAYER                      │
│  ┌────────────────────────────────────────────────────┐    │
│  │              CodeIgniter Query Builder              │    │
│  └────────────────────────────────────────────────────┘    │
└─────────────────────────────────────────────────────────────┘
                            ↓ ↑
┌─────────────────────────────────────────────────────────────┐
│                       DATABASE LAYER                         │
│  ┌────────┐  ┌────────┐  ┌──────────────┐                  │
│  │ users  │  │ cities │  │ weather_logs │                  │
│  └────────┘  └────────┘  └──────────────┘                  │
│                   MySQL Database                             │
└─────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────┐
│                    EXTERNAL SERVICES                         │
│  ┌────────────────────────────────────────────────────┐    │
│  │         OpenWeatherMap API (REST)                   │    │
│  │  GET /data/2.5/weather?q={city}&appid={key}        │    │
│  └────────────────────────────────────────────────────┘    │
└─────────────────────────────────────────────────────────────┘
```

### 2.2 Request Flow

1. **User Request** → Browser sends HTTP request
2. **Router** → Routes.php matches URL to controller method
3. **Filter** → AuthFilter/AdminFilter validates session & permissions
4. **Controller** → Processes request, validates input
5. **Model** → Interacts with database using Query Builder
6. **External API** (if needed) → Fetches data from OpenWeatherMap
7. **View** → Renders HTML with data
8. **Response** → Returns to browser

---

## 3. Database Design

### 3.1 Entity Relationship (ER) Diagram

```
┌─────────────────────────┐
│        users            │
├─────────────────────────┤
│ PK  id (INT)           │
│     username (VARCHAR)  │
│     password (VARCHAR)  │
│     role (ENUM)        │
│     created_at         │
│     updated_at         │
└─────────────────────────┘
          
          
┌─────────────────────────┐          ┌──────────────────────────┐
│        cities           │          │     weather_logs         │
├─────────────────────────┤          ├──────────────────────────┤
│ PK  id (INT)           │◄─────────┤ FK  city_id (INT)       │
│     city_name (VARCHAR)│ 1      * │ PK  id (INT)            │
│     country_code       │          │     temperature (DECIMAL)│
│     created_at         │          │     feels_like (DECIMAL) │
│     updated_at         │          │     humidity (INT)       │
└─────────────────────────┘          │     condition (VARCHAR)  │
                                     │     description (VARCHAR)│
                                     │     wind_speed (DECIMAL) │
                                     │     fetched_at (DATETIME)│
                                     │     created_at           │
                                     └──────────────────────────┘

Relationships:
- cities (1) ──→ (Many) weather_logs
- Foreign Key: weather_logs.city_id REFERENCES cities.id
- On Delete: CASCADE
- On Update: CASCADE
```

### 3.2 Table Specifications

#### users
```sql
CREATE TABLE users (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at DATETIME,
    updated_at DATETIME,
    INDEX idx_username (username),
    INDEX idx_role (role)
);
```

#### cities
```sql
CREATE TABLE cities (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    city_name VARCHAR(100) NOT NULL,
    country_code VARCHAR(10) NOT NULL,
    created_at DATETIME,
    updated_at DATETIME,
    INDEX idx_city_name (city_name)
);
```

#### weather_logs
```sql
CREATE TABLE weather_logs (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    city_id INT(11) UNSIGNED NOT NULL,
    temperature DECIMAL(5,2) NOT NULL,
    feels_like DECIMAL(5,2),
    humidity INT(3),
    condition VARCHAR(100) NOT NULL,
    description VARCHAR(255),
    wind_speed DECIMAL(5,2),
    fetched_at DATETIME NOT NULL,
    created_at DATETIME,
    FOREIGN KEY (city_id) REFERENCES cities(id) 
        ON DELETE CASCADE ON UPDATE CASCADE,
    INDEX idx_city_id (city_id),
    INDEX idx_fetched_at (fetched_at)
);
```

---

## 4. Authentication & Authorization

### 4.1 Authentication Flow

```
┌──────────────┐
│ Login Page   │
└──────┬───────┘
       │ POST /login
       ↓
┌────────────────────────┐
│ AuthController         │
│ - Validate Input       │
│ - Check Username       │
│ - Verify Password      │
└────────┬───────────────┘
         │
         ↓
    ┌────────┐
    │Success?│
    └───┬────┘
        │
   ┌────┴────┐
   │         │
  Yes       No
   │         │
   ↓         ↓
┌─────────┐ ┌────────────┐
│Set      │ │Show Error  │
│Session: │ │Message     │
│- id     │ └────────────┘
│- username│
│- role   │
│- isLoggedIn│
└────┬────┘
     │
     ↓
┌──────────────┐
│Redirect to   │
│Dashboard     │
└──────────────┘
```

### 4.2 Session Management

**Session Data Structure**:
```php
[
    'id' => 1,
    'username' => 'admin',
    'role' => 'admin',
    'isLoggedIn' => true
]
```

**Session Configuration**:
- Driver: FileHandler
- Expiration: Browser session
- Storage: writable/session/

### 4.3 Route Protection

**Filter Pipeline**:
```php
Request → GuestFilter (for login page)
        → AuthFilter (requires login)
        → AdminFilter (requires admin role)
        → Controller
```

**Filter Logic**:
```php
AuthFilter: Check session()->get('isLoggedIn')
AdminFilter: Check session()->get('role') == 'admin'
GuestFilter: Redirect if already logged in
```

---

## 5. API Integration

### 5.1 OpenWeatherMap Integration

**API Configuration**:
```env
weather.apiKey = your_api_key_here
weather.apiURL = https://api.openweathermap.org/data/2.5/weather
```

**Request Structure**:
```
GET https://api.openweathermap.org/data/2.5/weather
    ?q={city_name}
    &appid={api_key}
    &units=metric
```

**Response Example**:
```json
{
  "weather": [
    {
      "main": "Clear",
      "description": "clear sky"
    }
  ],
  "main": {
    "temp": 22.5,
    "feels_like": 21.8,
    "humidity": 65
  },
  "wind": {
    "speed": 3.5
  }
}
```

### 5.2 Data Caching Strategy

**Cache Flow**:
```
User Request Weather
    ↓
Check Database for Recent Data (< 30 min)
    ↓
┌───────┴───────┐
│               │
Found         Not Found
│               │
↓               ↓
Return        Fetch from API
Cached            ↓
Data          Save to DB
                  ↓
              Return Fresh Data
```

**Benefits**:
- Reduced API calls
- Faster response times
- Historical data tracking
- Cost savings (API limits)

---

## 6. Security Implementation

### 6.1 Password Security

**Hashing**:
```php
// During registration/update
password_hash($password, PASSWORD_DEFAULT);

// Algorithm: bcrypt
// Cost: 10 (default)
// Result: 60-character hash
```

**Verification**:
```php
password_verify($inputPassword, $hashedPassword);
```

### 6.2 CSRF Protection

**Implementation**:
```php
// In forms
<?= csrf_field() ?>

// Generates hidden field
<input type="hidden" name="csrf_token_name" value="random_token">

// Auto-validated by CodeIgniter
```

### 6.3 Input Validation

**Validation Rules**:
```php
// User
'username' => 'required|min_length[3]|is_unique[users.username]'
'password' => 'required|min_length[6]'
'role' => 'in_list[admin,user]'

// City
'city_name' => 'required|min_length[2]'
'country_code' => 'required|min_length[2]|max_length[10]'

// Weather
'temperature' => 'required|decimal'
'humidity' => 'integer'
```

### 6.4 XSS Protection

**Output Escaping**:
```php
<?= esc($data) ?> // HTML escape
<?= esc($data, 'url') ?> // URL encode
<?= esc($data, 'js') ?> // JavaScript escape
```

### 6.5 SQL Injection Prevention

**Query Builder** (Prepared Statements):
```php
$this->db->table('users')
         ->where('username', $username)
         ->get();

// Generates: 
// SELECT * FROM users WHERE username = ?
// Parameters: [$username]
```

---

## 7. Frontend Architecture

### 7.1 Layout System

**Template Inheritance**:
```
layout/main.php (Master Template)
    ↓
dashboard/index.php (Extends main.php)
weather/index.php (Extends main.php)
cities/index.php (Extends main.php)
```

**Sections**:
```php
<?= $this->section('content') ?>
    <!-- Page content -->
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <!-- Page-specific JS -->
<?= $this->endSection() ?>
```

### 7.2 Bootstrap Components Used

- **Grid System**: Responsive layout
- **Cards**: Content containers
- **Forms**: Input controls
- **Navbar**: Navigation
- **Modals**: Dialogs (optional)
- **Alerts**: Flash messages
- **Tables**: Data display
- **Badges**: Labels & tags
- **Buttons**: Actions

### 7.3 Chart.js Implementation

**Temperature Trend Chart**:
```javascript
new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Jan 01', 'Jan 02', ...],
        datasets: [{
            label: 'Temperature (°C)',
            data: [22.5, 23.1, 21.8, ...],
            borderColor: 'rgb(255, 99, 132)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { title: { text: 'Temperature (°C)' }},
            y1: { title: { text: 'Humidity (%)' }}
        }
    }
});
```

---

## 8. File Structure & Organization

```
WeatherTracker/
│
├── app/
│   ├── Config/
│   │   ├── App.php              # App configuration
│   │   ├── Database.php         # Database config
│   │   ├── Routes.php           # URL routing
│   │   └── Filters.php          # Filter registration
│   │
│   ├── Controllers/
│   │   ├── AuthController.php   # Login/logout/register
│   │   ├── UserController.php   # User CRUD
│   │   ├── CityController.php   # City CRUD
│   │   ├── WeatherController.php # Weather API + views
│   │   └── DashboardController.php # Dashboard stats
│   │
│   ├── Models/
│   │   ├── UserModel.php        # User database operations
│   │   ├── CityModel.php        # City database operations
│   │   └── WeatherModel.php     # Weather log operations
│   │
│   ├── Views/
│   │   ├── layout/
│   │   │   └── main.php         # Master template
│   │   ├── auth/
│   │   │   ├── login.php        # Login form
│   │   │   └── register.php     # User registration
│   │   ├── dashboard/
│   │   │   └── index.php        # Dashboard view
│   │   ├── weather/
│   │   │   ├── index.php        # Weather list
│   │   │   └── view.php         # Weather details + chart
│   │   ├── cities/
│   │   │   ├── index.php        # City list
│   │   │   ├── create.php       # Add city form
│   │   │   └── edit.php         # Edit city form
│   │   └── users/
│   │       ├── index.php        # User list
│   │       └── edit.php         # Edit user form
│   │
│   ├── Filters/
│   │   ├── AuthFilter.php       # Check if logged in
│   │   ├── AdminFilter.php      # Check if admin
│   │   └── GuestFilter.php      # Redirect if logged in
│   │
│   └── Database/
│       ├── Migrations/
│       │   ├── 2025-11-09-081600_CreateUsersTable.php
│       │   ├── 2025-11-09-081609_CreateCitiesTable.php
│       │   └── 2025-11-09-081617_CreateWeatherLogsTable.php
│       └── Seeds/
│           ├── UserSeeder.php
│           └── CitySeeder.php
│
├── public/
│   ├── index.php                # Application entry point
│   └── .htaccess                # Apache rewrite rules
│
├── writable/
│   ├── cache/                   # Application cache
│   ├── logs/                    # Error logs
│   └── session/                 # Session files
│
├── vendor/                      # Composer dependencies
├── .env                         # Environment configuration
├── database.sql                 # Database schema + data
├── README.md                    # User documentation
├── TECHNICAL_REPORT.md          # This file
└── composer.json                # PHP dependencies
```

---

## 9. Deployment Guide

### 9.1 Production Checklist

- [ ] Set `CI_ENVIRONMENT = production` in `.env`
- [ ] Enable HTTPS (`app.forceGlobalSecureRequests = true`)
- [ ] Change default admin password
- [ ] Set strong database password
- [ ] Configure error logging (not display)
- [ ] Enable CSRF protection (already on)
- [ ] Set up regular database backups
- [ ] Configure session security
- [ ] Update API key restrictions
- [ ] Test all security features

### 9.2 Server Requirements

**Minimum**:
- PHP 8.1+
- MySQL 5.7+
- Apache 2.4+ with mod_rewrite
- 256MB RAM
- 100MB disk space

**Recommended**:
- PHP 8.2+
- MySQL 8.0+
- 512MB RAM
- SSL certificate
- CDN for static assets

### 9.3 Performance Optimization

**Database**:
```sql
-- Add indexes for frequent queries
CREATE INDEX idx_city_weather ON weather_logs(city_id, fetched_at);
CREATE INDEX idx_username_login ON users(username, password);
```

**Caching**:
- Enable OpCache for PHP
- Use Redis for sessions (optional)
- Implement page caching for public views

**Frontend**:
- Minify CSS/JS
- Enable GZIP compression
- Use CDN for libraries
- Lazy load images

---

## 10. Testing Strategy

### 10.1 Unit Testing

**Example Test** (PHPUnit):
```php
class UserModelTest extends CIUnitTestCase
{
    public function testUserCreation()
    {
        $model = new UserModel();
        $data = [
            'username' => 'testuser',
            'password' => 'password123',
            'role' => 'user'
        ];
        
        $result = $model->save($data);
        $this->assertTrue($result);
    }
}
```

### 10.2 Integration Testing

**Test Cases**:
1. User login flow
2. Weather API fetch and cache
3. CRUD operations for cities
4. Role-based access control
5. Form validation

### 10.3 Manual Testing Checklist

**Authentication**:
- [ ] Login with valid credentials
- [ ] Login with invalid credentials
- [ ] Logout functionality
- [ ] Session persistence

**Admin Features**:
- [ ] Create new city
- [ ] Edit city
- [ ] Delete city
- [ ] Create user
- [ ] Edit user
- [ ] Delete user

**Weather Features**:
- [ ] Fetch individual city weather
- [ ] Fetch all cities weather
- [ ] View weather history
- [ ] Chart rendering

**Security**:
- [ ] CSRF token validation
- [ ] SQL injection attempts
- [ ] XSS prevention
- [ ] Unauthorized access attempts

---

## 11. API Documentation

### 11.1 Internal Routes

#### Public Routes
```
GET  /              → AuthController::login
POST /login         → AuthController::loginProcess
GET  /logout        → AuthController::logout
```

#### Protected Routes (Authenticated)
```
GET  /dashboard     → DashboardController::index
GET  /weather       → WeatherController::index
GET  /weather/fetch/{id} → WeatherController::fetch
GET  /weather/view/{id}  → WeatherController::view
```

#### Admin-Only Routes
```
GET  /cities                → CityController::index
GET  /cities/create         → CityController::create
POST /cities/store          → CityController::store
GET  /cities/edit/{id}      → CityController::edit
POST /cities/update/{id}    → CityController::update
GET  /cities/delete/{id}    → CityController::delete

GET  /users                 → UserController::index
GET  /register              → AuthController::register
POST /register              → AuthController::registerProcess
GET  /users/edit/{id}       → UserController::edit
POST /users/update/{id}     → UserController::update
GET  /users/delete/{id}     → UserController::delete

GET  /weather/fetch-all     → WeatherController::fetchAll
```

---

## 12. Maintenance & Support

### 12.1 Logging

**Location**: `writable/logs/log-YYYY-MM-DD.log`

**Log Levels**:
- ERROR: Critical errors
- WARNING: Warnings
- INFO: Information
- DEBUG: Debug messages (development only)

**Example**:
```
ERROR - 2025-11-09 → Weather API failed for city: London
INFO  - 2025-11-09 → User 'admin' logged in successfully
```

### 12.2 Backup Strategy

**Database Backup**:
```bash
# Daily backup
mysqldump -u root -p weather_tracker > backup_$(date +%Y%m%d).sql

# Automated via cron
0 2 * * * mysqldump -u root -p weather_tracker > /backups/db_$(date +\%Y\%m\%d).sql
```

**File Backup**:
- `.env` file
- `writable/uploads/` (if any)
- Custom configurations

---

## 13. Future Enhancements

### 13.1 Proposed Features

1. **Multi-language Support**: i18n implementation
2. **Email Notifications**: Weather alerts
3. **Advanced Charts**: 7-day forecast
4. **Export Features**: CSV/PDF reports
5. **API Rate Limiting**: Prevent abuse
6. **User Preferences**: Custom dashboard
7. **Mobile App**: React Native/Flutter
8. **Geolocation**: Auto-detect user city
9. **Weather Widgets**: Embeddable components
10. **Social Sharing**: Share weather data

### 13.2 Scalability Considerations

- Implement Redis caching
- Database read replicas
- Load balancing (multiple servers)
- Microservices architecture
- Queue system for API calls
- CDN integration

---

## 14. Conclusion

The Weather Tracker Dashboard successfully demonstrates:

✅ **Full-Stack Development**: Complete MVC implementation  
✅ **API Integration**: Real-time external data fetching  
✅ **Security Best Practices**: Authentication, authorization, validation  
✅ **Modern UI/UX**: Responsive Bootstrap design  
✅ **Data Visualization**: Interactive Chart.js charts  
✅ **Code Quality**: Clean, modular, maintainable code  
✅ **Documentation**: Comprehensive technical and user docs  

### Key Achievements

1. **Modular Architecture**: Easy to extend and maintain
2. **Security First**: Multiple layers of protection
3. **User-Friendly**: Intuitive interface for all roles
4. **Scalable Design**: Ready for production deployment
5. **Best Practices**: Following CodeIgniter & PHP standards

---

## 15. Appendix

### 15.1 Glossary

- **MVC**: Model-View-Controller architectural pattern
- **CRUD**: Create, Read, Update, Delete operations
- **CSRF**: Cross-Site Request Forgery
- **XSS**: Cross-Site Scripting
- **ORM**: Object-Relational Mapping
- **API**: Application Programming Interface
- **REST**: Representational State Transfer

### 15.2 References

- [CodeIgniter 4 Documentation](https://codeigniter.com/user_guide/)
- [Bootstrap 5 Documentation](https://getbootstrap.com/docs/)
- [Chart.js Documentation](https://www.chartjs.org/docs/)
- [OpenWeatherMap API](https://openweathermap.org/api)
- [PHP Manual](https://www.php.net/manual/)
- [MySQL Documentation](https://dev.mysql.com/doc/)

### 15.3 Contact & Support

For technical support or questions:
- Review documentation
- Check error logs
- Consult CodeIgniter community
- Review GitHub issues

---

**Document Version**: 1.0  
**Last Updated**: November 9, 2025  
**Author**: Weather Tracker Development Team
