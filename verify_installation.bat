@echo off
echo ============================================
echo Weather Tracker Dashboard - Installation Verification
echo ============================================
echo.

echo Checking PHP version...
php -v
echo.

echo Checking if Composer is installed...
composer --version
echo.

echo Checking MySQL connection...
echo Please ensure MySQL is running in XAMPP Control Panel
echo.

echo Checking project structure...
echo.

if exist "app\Controllers\AuthController.php" (
    echo [OK] AuthController found
) else (
    echo [ERROR] AuthController missing
)

if exist "app\Controllers\WeatherController.php" (
    echo [OK] WeatherController found
) else (
    echo [ERROR] WeatherController missing
)

if exist "app\Controllers\CityController.php" (
    echo [OK] CityController found
) else (
    echo [ERROR] CityController missing
)

if exist "app\Controllers\UserController.php" (
    echo [OK] UserController found
) else (
    echo [ERROR] UserController missing
)

if exist "app\Controllers\DashboardController.php" (
    echo [OK] DashboardController found
) else (
    echo [ERROR] DashboardController missing
)

echo.

if exist "app\Models\UserModel.php" (
    echo [OK] UserModel found
) else (
    echo [ERROR] UserModel missing
)

if exist "app\Models\CityModel.php" (
    echo [OK] CityModel found
) else (
    echo [ERROR] CityModel missing
)

if exist "app\Models\WeatherModel.php" (
    echo [OK] WeatherModel found
) else (
    echo [ERROR] WeatherModel missing
)

echo.

if exist ".env" (
    echo [OK] .env file found
) else (
    echo [WARNING] .env file not found - copy from env or .env.example
)

if exist "database.sql" (
    echo [OK] database.sql found
) else (
    echo [ERROR] database.sql missing
)

if exist "README.md" (
    echo [OK] README.md found
) else (
    echo [ERROR] README.md missing
)

if exist "TECHNICAL_REPORT.md" (
    echo [OK] TECHNICAL_REPORT.md found
) else (
    echo [ERROR] TECHNICAL_REPORT.md missing
)

echo.
echo ============================================
echo Verification Complete!
echo ============================================
echo.
echo Next Steps:
echo 1. Ensure MySQL is running in XAMPP
echo 2. Import database.sql into phpMyAdmin
echo 3. Update .env with your OpenWeatherMap API key
echo 4. Access: http://localhost/WeatherTracker/public/
echo 5. Login: admin / admin123
echo.
echo For detailed setup instructions, see:
echo - SETUP_GUIDE.md (Quick Setup)
echo - README.md (Full Documentation)
echo.

pause
