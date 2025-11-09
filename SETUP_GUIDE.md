# Weather Tracker - Quick Setup Guide

## Prerequisites Checklist
- [ ] XAMPP installed and running
- [ ] PHP 8.1 or higher
- [ ] MySQL service started
- [ ] OpenWeatherMap API key obtained

---

## 🚀 Quick Start (5 Minutes)

### Step 1: Database Setup
1. Open browser: `http://localhost/phpmyadmin`
2. Click "Import" tab
3. Select file: `database.sql`
4. Click "Go"

### Step 2: Configure API Key
1. Open file: `.env`
2. Find line: `weather.apiKey = YOUR_API_KEY_HERE`
3. Replace with your OpenWeatherMap API key
4. Save file

### Step 3: Access Application
1. Open browser
2. Go to: `http://localhost/WeatherTracker/public/`
3. Login with:
   - **Admin**: `admin` / `admin123`
   - **User**: `user` / `user123`

---

## ✅ Verification Steps

### Test Login
- [ ] Can login as admin
- [ ] Can login as user
- [ ] Can logout

### Test Dashboard
- [ ] Dashboard shows statistics
- [ ] Recent weather updates visible
- [ ] Navigation sidebar works

### Test Weather (after adding API key)
- [ ] Can view weather for cities
- [ ] Can fetch fresh weather data
- [ ] Can view weather details with chart

### Test Admin Features (login as admin)
- [ ] Can add new city
- [ ] Can edit city
- [ ] Can delete city
- [ ] Can add new user
- [ ] Can edit user
- [ ] Can delete user

---

## 🔧 Configuration Details

### Database Connection (.env)
```env
database.default.hostname = localhost
database.default.database = weather_tracker
database.default.username = root
database.default.password = 
```

### API Configuration (.env)
```env
weather.apiKey = YOUR_OPENWEATHERMAP_API_KEY
weather.apiURL = https://api.openweathermap.org/data/2.5/weather
```

### Base URL (.env)
```env
app.baseURL = 'http://localhost/WeatherTracker/public/'
```

---

## 📚 Default Data

### Users
| Username | Password | Role |
|----------|----------|------|
| admin    | admin123 | admin|
| user     | user123  | user |

### Cities
- London, GB
- New York, US
- Tokyo, JP
- Paris, FR
- Sydney, AU
- Dubai, AE
- Singapore, SG
- Mumbai, IN

---

## 🛠️ Troubleshooting

### "Database connection failed"
**Fix**: 
- Ensure MySQL is running in XAMPP
- Verify database `weather_tracker` exists
- Check username/password in `.env`

### "404 Not Found"
**Fix**:
- Check URL: `http://localhost/WeatherTracker/public/`
- Verify `.htaccess` exists in `public/` folder
- Ensure mod_rewrite is enabled in Apache

### "Weather API error"
**Fix**:
- Verify API key in `.env`
- Check internet connection
- Wait 2 hours after creating API key (activation time)
- Test API key: `https://api.openweathermap.org/data/2.5/weather?q=London&appid=YOUR_KEY`

### "CSRF token mismatch"
**Fix**:
- Clear browser cache and cookies
- Ensure forms include `<?= csrf_field() ?>`
- Check session configuration

---

## 🎯 First-Time Admin Tasks

After successful login as admin:

1. **Update Admin Password**
   - Go to "Manage Users"
   - Edit admin user
   - Change password
   - Save

2. **Add Your Cities**
   - Go to "Manage Cities"
   - Click "Add New City"
   - Enter city name and country code
   - Save

3. **Fetch Weather Data**
   - Go to "Weather"
   - Click "Fetch All Weather" button
   - Wait for data to load
   - View updated weather cards

4. **Create Additional Users**
   - Go to "Manage Users"
   - Click "Add New User"
   - Fill in details
   - Assign role
   - Save

---

## 📖 User Guide

### For Admin Users
- Full access to all features
- Can manage cities (add/edit/delete)
- Can manage users (add/edit/delete)
- Can fetch weather data
- Can view weather history and charts

### For Regular Users
- Can view dashboard
- Can view weather for all cities
- Can fetch individual city weather
- Can view weather history and charts
- Cannot manage cities or users

---

## 🔐 Security Best Practices

For Production Use:

1. **Change Environment**
   ```env
   CI_ENVIRONMENT = production
   ```

2. **Enable HTTPS**
   ```env
   app.forceGlobalSecureRequests = true
   ```

3. **Update Passwords**
   - Change all default passwords
   - Use strong passwords (12+ characters)

4. **Secure Database**
   - Set strong MySQL root password
   - Create dedicated database user
   - Grant minimal permissions

5. **Protect Files**
   - Set proper file permissions
   - Restrict .env file access
   - Disable directory listing

---

## 📞 Getting Help

### Resources
- **User Documentation**: README.md
- **Technical Documentation**: TECHNICAL_REPORT.md
- **CodeIgniter Guide**: https://codeigniter.com/user_guide/
- **Bootstrap Docs**: https://getbootstrap.com/docs/
- **Chart.js Docs**: https://www.chartjs.org/docs/

### Error Logs
Check: `writable/logs/log-YYYY-MM-DD.log`

---

## 🎉 You're Ready!

Your Weather Tracker Dashboard is now set up and ready to use.

**Next Steps**:
1. Login and explore the dashboard
2. Add your OpenWeatherMap API key
3. Fetch weather data for cities
4. View weather trends with charts
5. Customize cities based on your needs

**Enjoy tracking weather! 🌤️**
