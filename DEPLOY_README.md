# 🚀 HULAHUP APP - QUICK DEPLOYMENT GUIDE

## ⚡ Mulai dalam 30 Menit!

### STEP 1️⃣: Persiapan Lokal (Windows)

```powershell
# Buka PowerShell, masuk ke folder project
cd c:\xampp\hulahup-app

# Jalankan script setup otomatis
.\setup-deployment.bat

# Atau jalankan manual:
composer install --optimize-autoloader --no-dev
npm install
npm run build
php artisan key:generate --show
```

### STEP 2️⃣: Buat Repository GitHub

1. Buka: https://github.com/new
2. **Name:** `hulahup-app`
3. **Description:** Canteen Order System
4. Klik **Create repository**

### STEP 3️⃣: Push ke GitHub

```powershell
git init
git config user.name "Your Name"
git config user.email "your@email.com"
git add .
git commit -m "Initial commit: Hulahup App"
git remote add origin https://github.com/YOUR_USERNAME/hulahup-app.git
git branch -M main
git push -u origin main
```

### STEP 4️⃣: Deploy ke Railway (RECOMMENDED)

```
1. Buka https://railway.app
2. Login dengan GitHub
3. Klik "New Project"
4. Pilih repository "hulahup-app"
5. Railway auto-deploy! ✅
6. Tambah MySQL database
7. Set environment variables dari .env.production.example
```

### STEP 5️⃣: Setup Database di Railway

```bash
# Via Railway Shell:
php artisan migrate --force
php artisan storage:link
```

### ✅ SELESAI! 🎉

**Akses aplikasi:** `https://your-app.up.railway.app`

**Bisa dibuka dari:**
- 📱 Phone/HP (Chrome, Safari, Firefox)
- 💻 Laptop/Desktop
- ⌚ Tablet
- 🌍 Mana saja (asalkan ada internet)

---

## 📚 DOKUMENTASI LENGKAP

- [Panduan Lengkap](./DEPLOYMENT_GUIDE.md) - Step-by-step detailed
- [Railway Setup](./RAILWAY_SETUP.md) - Konfigurasi Railway spesifik
- [Checklist](./DEPLOYMENT_CHECKLIST.json) - Task checklist lengkap

---

## 🆘 TROUBLESHOOTING

### Build Failed?
- Check Railway Build Logs
- Pastikan `.gitignore` benar
- Force rebuild: `git commit --allow-empty -m "Rebuild" && git push`

### Database Error?
- Set DB credentials di Railway Variables
- Run migrations: `php artisan migrate --force`

### CSS/JS Not Loading?
- Run: `npm run build`
- Push ke GitHub: Railway auto-rebuild

### Blank Page?
- Check APP_KEY di .env
- Run: `php artisan config:cache`

---

## 🎯 NEXT STEPS

- [ ] Setup GitHub repository
- [ ] Push code ke GitHub  
- [ ] Deploy ke Railway
- [ ] Setup database
- [ ] Test dari phone/device
- [ ] Setup custom domain (optional)
- [ ] Monitor errors dengan Sentry (optional)

---

**Status:** Ready to Deploy ✅  
**Last Updated:** 2026-05-21

