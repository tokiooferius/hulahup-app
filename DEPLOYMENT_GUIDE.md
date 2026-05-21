# 📱 PANDUAN DEPLOYMENT HULAHUP APP
**Akses dari HP, Browser, dan Dimana Saja**

---

## ✅ TAHAP 1: PERSIAPAN LOKAL (5 menit)

### 1.1 Setup Git di Project

```powershell
# Masuk ke folder project
cd c:\xampp\hulahup-app

# Init git (jika belum ada .git folder)
git init

# Setup user git
git config user.name "Your Name"
git config user.email "your@email.com"

# Check status
git status
```

### 1.2 Optimize File untuk Upload

```powershell
# Bersihkan cache & temporary files
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Generate key production
php artisan key:generate --show
# Simpan output (kita butuh di hosting nanti)
```

### 1.3 Persiapkan Dependencies

```powershell
# Install composer dependencies (jika belum)
composer install --optimize-autoloader --no-dev

# Install node dependencies & build
npm install
npm run build
```

### 1.4 Verify Aplikasi Lokal

```powershell
# Test aplikasi lokal berjalan
php artisan serve
# Akses: http://localhost:8000
# Cek semua fitur bekerja dengan baik
```

---

## 📤 TAHAP 2: PUSH KE GITHUB (10 menit)

### 2.1 Buat Repository di GitHub

1. Buka https://github.com/new
2. **Repository name:** `hulahup-app`
3. **Description:** `Hulahup - Canteen Order System`
4. **Visibility:** Public (atau Private jika butuh)
5. **Skip** initializing with README/gitignore/license
6. Klik **Create repository**

### 2.2 Push Code ke GitHub

```powershell
# Add semua file
git add .

# Commit dengan pesan deskriptif
git commit -m "Initial commit: Hulahup App - Canteen Order System

- User authentication & roles (Admin, User, Canteen Staff)
- Payment integration (Midtrans)
- Menu & Order management
- Canteen settlement system"

# Add remote origin (ubah USERNAME dengan username GitHub Anda)
git remote add origin https://github.com/USERNAME/hulahup-app.git

# Rename branch ke main
git branch -M main

# Push ke GitHub
git push -u origin main

# Verify di https://github.com/USERNAME/hulahup-app
```

### 2.3 Buat `.gitignore` Tambahan (Optional tapi Recommended)

File `.gitignore` sudah ada, pastikan berisi:
- `/vendor` ✅
- `/node_modules` ✅
- `.env` ✅
- `/storage/logs/*` ✅
- `/public/storage` ✅

---

## 🚀 TAHAP 3: PILIH DEPLOYMENT PLATFORM

### Perbandingan Platform:

| Platform | Gratis | Setup | Database | Domain | Akses HP |
|----------|--------|-------|----------|--------|----------|
| **Railway** ⭐ | Tier gratis | Easiest | PostgreSQL/MySQL | Subdomain gratis | ✅ |
| **Heroku** | Berbayar | Mudah | Add-on berbayar | Subdomain gratis | ✅ |
| **Vercel** | Gratis | Kompleks untuk Laravel | Tidak cocok | Gratis | ❌ |
| **PlanetScale** | Gratis tier | Sedang | MySQL gratis | Cloud DB only | N/A |
| **Hosting Indo** (Niagahoster, Hostinger) | $50+/tahun | FTP upload | Included | Domain | ✅ |
| **DigitalOcean App Platform** | $5-12/bulan | Mudah | Included | Custom domain | ✅ |

**🎯 REKOMENDASI: Railway** (Paling simpel untuk Laravel)

---

## 🎯 DEPLOYMENT VIA RAILWAY (RECOMMENDED)

### 3.1 Setup Railway

```
1. Buka https://railway.app
2. Klik "Start a new project"
3. Login dengan GitHub
4. Pilih repository: hulahup-app
5. Railway otomatis detect Laravel ✅
6. Wait for build (~2-3 menit)
```

### 3.2 Konfigurasi Environment Variables

Di Railway Dashboard, klik "Variables" dan set:

```env
APP_NAME=HulahupApp
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.up.railway.app

APP_KEY=base64:WAPd7wVwBvqGdWldN+8YmdE+ivk7pzg0CWXaAXi3MnE=

DB_CONNECTION=mysql
DB_HOST=${{MYSQL.PRIVATE_URL}}
DB_PORT=3306
DB_DATABASE=railway
DB_USERNAME=${{MYSQL.USER}}
DB_PASSWORD=${{MYSQL.PASSWORD}}

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
FILESYSTEM_DISK=local

LOG_CHANNEL=stack
LOG_LEVEL=info
```

### 3.3 Add MySQL Database di Railway

```
1. Klik "+ Add" di Railway project
2. Pilih "MySQL"
3. Create & wait untuk provisioning
4. Variables otomatis di-generate ✅
```

### 3.4 Database Migration setelah Deploy

```powershell
# SSH ke Railway (atau jalankan command via Railway UI)
php artisan migrate --force
php artisan db:seed --force  # Jika butuh data default
php artisan storage:link
```

### 3.5 Akses Aplikasi

```
URL: https://your-app.up.railway.app
Bisa diakses dari browser apapun di HP, Laptop, Desktop ✅
```

---

## 🎯 ALTERNATIVE: DEPLOYMENT VIA HEROKU

### Setup Heroku

```powershell
# Install Heroku CLI
# https://devcenter.heroku.com/articles/heroku-cli

# Login ke Heroku
heroku login

# Create app
heroku create your-app-name

# Setup buildpacks
heroku buildpacks:add heroku/php
heroku buildpacks:add heroku/nodejs

# Add MySQL addon (Cleardb)
heroku addons:create cleardb:ignite

# Set environment variables
heroku config:set APP_ENV=production
heroku config:set APP_DEBUG=false
heroku config:set LOG_CHANNEL=errorlog

# Automatic APP_KEY jika belum
heroku config:set APP_KEY=$(php artisan key:generate --show)

# Push ke Heroku
git push heroku main

# Database migration
heroku run php artisan migrate --force

# Open aplikasi
heroku open
```

---

## 🎯 ALTERNATIVE: VPS MURAH (DigitalOcean, Linode, Vultr)

### 3.1 Setup VPS

```bash
# 1. Create droplet di DigitalOcean ($5/bulan)
# - OS: Ubuntu 22.04
# - Size: Basic ($5/bulan)

# 2. SSH ke VPS
ssh root@your.ip.address

# 3. Install dependencies
apt update && apt upgrade -y
apt install -y php php-mysql php-mbstring php-xml php-zip git curl nodejs npm nginx mysql-server

# 4. Setup PHP FPM & Nginx
systemctl start php8.1-fpm nginx mysql-server

# 5. Clone repo GitHub
cd /var/www
git clone https://github.com/USERNAME/hulahup-app.git
cd hulahup-app

# 6. Install dependencies
composer install --optimize-autoloader --no-dev
npm install && npm run build

# 7. Setup permissions
chown -R www-data:www-data /var/www/hulahup-app
chmod -R 755 /var/www/hulahup-app/storage

# 8. Setup .env
cp .env.example .env
nano .env
# Set DB credentials & APP_URL

# 9. Database
mysql -u root -p
CREATE DATABASE hulahup_db;
CREATE USER 'hulahup'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON hulahup_db.* TO 'hulahup'@'localhost';
FLUSH PRIVILEGES;
EXIT;

# 10. Migration
php artisan migrate --force
php artisan storage:link

# 11. Configure Nginx
# Copy Nginx config untuk Laravel
```

---

## 📱 AKSES DARI HP/DEVICE

### Setelah Deploy Berhasil:

```
Desktop Browser:
  https://your-app.up.railway.app

Android:
  Chrome → https://your-app.up.railway.app
  
iPhone/iPad:
  Safari → https://your-app.up.railway.app

Local Network (Same WiFi):
  http://192.168.x.x (jika local server)
```

### Buat PWA (Progressive Web App) - Optional

Dengan PWA, user bisa:
- Install sebagai app di Home Screen
- Offline support
- Push notifications

Tambah di `bootstrap/app.php`:
```php
// ... existing code
// Add PWA manifest at public/manifest.json
```

---

## ⚙️ OPTIMIZATION CHECKLIST

### Performance

- [ ] Enable gzip compression di Nginx/Apache
- [ ] Cache CSS/JS dengan versioning (Vite)
- [ ] Database indexing di migrations
- [ ] Queue jobs untuk email/heavy tasks
- [ ] CDN untuk static assets (optional)

### Security

- [ ] Set `APP_DEBUG=false` di production
- [ ] Enable HTTPS (Railway/Heroku auto-HTTPS)
- [ ] Enable CSRF protection (sudah default)
- [ ] Set secure headers di middleware
- [ ] Regular security updates

### Monitoring

- [ ] Setup error logging (Sentry - free tier)
- [ ] Monitor uptime (UptimeRobot - free)
- [ ] Email alerts untuk errors
- [ ] Backup database regular (Railway auto-backup)

---

## 🐛 TROUBLESHOOTING

### Build Failed di Railway

```
1. Check Build Logs di Railway Dashboard
2. Common issues:
   - Missing npm dependencies → npm install
   - PHP version mismatch → Check composer.json
   - Disk space → Increase quota
3. Force rebuild: Push empty commit
   git commit --allow-empty -m "Rebuild"
   git push
```

### Database Connection Error

```
1. Verify credentials di .env
2. Check firewall/network access
3. Ensure database is running
4. Test connection: php artisan tinker → \DB::connection()->getPdo()
```

### Blank Page / 500 Error

```
1. Check logs: tail -f /path/to/storage/logs/laravel.log
2. Verify APP_KEY is set
3. Run: php artisan config:cache
4. Check database migrations: php artisan migrate:status
```

### Assets (CSS/JS) Not Loading

```
1. Run: npm run build
2. Clear cache: php artisan view:cache
3. Verify vite.config.js paths
4. Check public/build directory exists
```

---

## 📊 RECOMMENDED FLOW

```
1. LOCAL DEV
   ↓
2. PUSH TO GITHUB
   ↓
3. DEPLOY TO RAILWAY (atau Heroku/VPS)
   ↓
4. RUN MIGRATIONS
   ↓
5. SETUP CUSTOM DOMAIN (Optional)
   ↓
6. SHARE URL: https://your-app.up.railway.app
   ↓
7. ACCESS FROM ANYWHERE ✅
```

---

## 📞 QUICK COMMANDS

```powershell
# Local Development
php artisan serve                    # Run local server
npm run dev                          # Watch frontend changes
npm run build                        # Build for production

# Git Operations
git add .                           # Stage changes
git commit -m "message"             # Commit
git push                            # Push to GitHub
git pull                            # Pull latest

# Database
php artisan migrate                 # Run migrations
php artisan db:seed                 # Seed data
php artisan migrate:refresh         # Reset & migrate

# Cache & Optimization
php artisan cache:clear             # Clear cache
php artisan config:cache            # Cache config
php artisan route:cache             # Cache routes
php artisan view:cache              # Cache views

# Deployment (Railway)
# Push to main branch = Auto deploy ✅
```

---

## ✨ KESIMPULAN

✅ **Git Setup** → Push to GitHub  
✅ **Choose Platform** → Railway (easiest)  
✅ **Configure DB** → MySQL in Railway  
✅ **Run Migrations** → php artisan migrate  
✅ **Share URL** → Bisa diakses dari mana saja 📱

**Target selesai**: 30 menit sampai aplikasi live & accessible dari HP!

---

*Last Updated: May 21, 2026*
*Laravel 12 • Vite • MySQL • Railway*
