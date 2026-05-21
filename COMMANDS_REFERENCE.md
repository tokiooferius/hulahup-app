# 📋 QUICK COMMAND REFERENCE

## 🚀 DEPLOYMENT FLOW

```powershell
# ===== PHASE 1: LOCAL SETUP =====
cd c:\xampp\hulahup-app
composer install --optimize-autoloader --no-dev
npm install && npm run build
php artisan key:generate --show

# ===== PHASE 2: GIT SETUP =====
git init
git config user.name "Your Name"
git config user.email "your@email.com"
git add .
git commit -m "Initial commit: Hulahup App"

# ===== PHASE 3: GITHUB PUSH =====
# 1. Buat repo di https://github.com/new
# 2. Jalankan:
git remote add origin https://github.com/USERNAME/hulahup-app.git
git branch -M main
git push -u origin main

# ===== PHASE 4: RAILWAY DEPLOY =====
# 1. Buka https://railway.app
# 2. Connect GitHub repository
# 3. Railway otomatis deploy!
```

---

## 🛠️ USEFUL COMMANDS

### Development
```powershell
php artisan serve                      # Start local server (http://localhost:8000)
npm run dev                            # Watch CSS/JS changes
npm run build                          # Build assets for production
```

### Database
```powershell
php artisan migrate                    # Run pending migrations
php artisan migrate:refresh            # Reset & migrate
php artisan migrate:fresh --seed       # Fresh + seeding
php artisan db:seed                    # Run seeders
php artisan tinker                     # Interactive shell
```

### Cache & Optimization
```powershell
php artisan cache:clear                # Clear all cache
php artisan config:cache               # Cache configuration
php artisan route:cache                # Cache routes
php artisan view:cache                 # Cache views
composer dump-autoload                 # Optimize autoloader
php artisan optimize                   # Optimize application
```

### Git Commands
```powershell
git status                             # Check status
git add .                              # Stage all changes
git commit -m "message"                # Commit changes
git push                               # Push to GitHub
git pull                               # Pull latest
git log --oneline                      # View commits
git branch                             # List branches
```

### Production (Hosting)
```bash
php artisan migrate --force            # Migrate in production
php artisan db:seed --force            # Seed in production  
php artisan config:cache               # Cache config
php artisan view:cache                 # Cache views
php artisan storage:link               # Create storage symlink
```

---

## 🔍 DEBUGGING

### Check Application Status
```powershell
php artisan tinker
> \DB::connection()->getPdo()          # Check DB connection
> config('app.debug')                  # Check debug mode
> env('APP_ENV')                       # Check environment
```

### View Logs
```bash
# Local
tail -f storage/logs/laravel.log

# Production (Railway)
# Via Railway Dashboard → Logs
```

### Clear Everything
```powershell
php artisan cache:clear
php artisan route:cache --forget
php artisan view:cache --forget
php artisan config:cache --forget
composer dump-autoload
```

---

## 📱 ACCESS FROM ANYWHERE

After deployment on Railway:

**URL:** `https://your-app.up.railway.app`

### From Phone/Tablet
1. Open Chrome/Safari/Firefox
2. Visit: `https://your-app.up.railway.app`
3. Done! ✅

### From Other Computer (Same Network)
1. Open browser
2. Visit: `http://192.168.x.x:8000` (jika local server)
   atau `https://your-app.up.railway.app`

---

## 🎯 COMMON SCENARIOS

### "I want to make changes and re-deploy"
```powershell
# 1. Make changes locally
# 2. Test locally: php artisan serve
# 3. Push to GitHub:
git add .
git commit -m "Feature: Description"
git push origin main
# 4. Railway auto-deploys! ✅
```

### "Database migration failed"
```powershell
# Check migrations
php artisan migrate:status

# If rollback needed
php artisan migrate:rollback

# Or fresh (dangerous - deletes all data!)
php artisan migrate:fresh
```

### "Cannot connect to database in production"
```bash
# SSH ke Railway
railway shell

# Check DB credentials
php artisan tinker
> env('DB_HOST')
> env('DB_USERNAME')

# Try connection
> \DB::connection()->getPdo()
```

### "CSS/JS not loading"
```powershell
# Rebuild frontend
npm run build

# Push to GitHub
git add public/build
git commit -m "Build: Update assets"
git push

# Railway auto-rebuilds ✅
```

---

## ✅ DEPLOYMENT CHECKLIST

- [ ] Run setup-deployment.bat locally
- [ ] Create GitHub repository
- [ ] Push code to GitHub
- [ ] Connect GitHub to Railway
- [ ] Add MySQL database in Railway
- [ ] Set environment variables
- [ ] Run migrations in Railway
- [ ] Test application
- [ ] Access from phone/other device
- [ ] Monitor logs for errors

---

## 🆘 GETTING HELP

### Railway Documentation
- https://docs.railway.app
- https://docs.railway.app/deploy/deployments

### Laravel Documentation  
- https://laravel.com/docs
- https://laravel.com/docs/migrations

### GitHub
- https://docs.github.com
- https://guides.github.com

---

**Pro Tips:**
- ✅ Always test locally before pushing
- ✅ Use meaningful commit messages
- ✅ Keep .env out of Git (already in .gitignore)
- ✅ Monitor production logs regularly
- ✅ Backup database regularly
- ✅ Update dependencies regularly

