# Railway.app Configuration untuk Hulahup App

## Sekilas Solusi (PR #4)

Aplikasi sekarang menggunakan **Dockerfile** dengan PHP built-in server yang robust:
- ✅ **`.env` file** dibuat otomatis di build time dari `.env.example`
- ✅ **Migrations** berjalan dengan fallback - server tetap jalan meski migration gagal (first deploy)
- ✅ **Error handling** yang proper dengan logging di `docker-entrypoint.sh`
- ✅ **Health checks** akan pass karena PHP server selalu berjalan

## Railway Deployment Steps

### 1. Connect GitHub & Deploy
- Push ke GitHub
- Connect Railway ke repo
- Railway akan auto-detect Dockerfile dan deploy

### 2. Setup Environment Variables
Di Railway Dashboard → Project → Variables, set:

```
# App Config
APP_NAME=HulahupApp
APP_ENV=production
APP_DEBUG=false
APP_KEY=
APP_URL=${{RAILWAY_PUBLIC_DOMAIN}}

# Database (MySQL di Railway)
DB_CONNECTION=mysql
DB_HOST=${{MYSQL.PRIVATE_URL}}
DB_PORT=3306
DB_DATABASE=railway
DB_USERNAME=${{MYSQL.USER}}
DB_PASSWORD=${{MYSQL.PASSWORD}}

# Session & Cache
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false

CACHE_STORE=database
QUEUE_CONNECTION=database
FILESYSTEM_DISK=local
BROADCAST_CONNECTION=log

# Logging
LOG_CHANNEL=stack
LOG_LEVEL=error
```

### 3. Setup MySQL Plugin
- Di Railway Dashboard, add plugin **MySQL** ke project
- Railway akan auto-inject `MYSQL_*` variables yang bisa di-reference sebagai `${{MYSQL.*}}`

### 4. Enable Health Check (Optional tapi Recommended)
Di Railway Service Settings:
- **Health Check Command**: `curl -f http://localhost:8000/ || exit 1`
- **Health Check Timeout**: 30 seconds
- **Health Check Interval**: 10 seconds

Railway akan retry deploy jika health check gagal.

### 5. Deploy
Push ke GitHub → Railway auto-build & deploy

## Troubleshooting

### Container tetap restart?
- Check logs di Railway: `deployments → view logs`
- Lihat error dari `docker-entrypoint.sh`
- Ensure `DB_HOST`, `DB_USER`, `DB_PASSWORD` benar di env vars

### Database error?
```
Access denied for user 'root'@'localhost'
```
- Pastikan MySQL plugin sudah terhubung
- Check `DB_HOST` menggunakan `${{MYSQL.PRIVATE_URL}}` (bukan localhost)
- Check `DB_PASSWORD` sudah ter-set

### Migrations stuck?
- App akan tetap serve meski migration gagal (ini by design)
- Check DB credentials terlebih dahulu
- Atau reset DB & re-deploy

## File Changes di PR #4

### ✅ Dockerfile
- Copy `.env.example` → `.env` di build time
- Use `docker-entrypoint.sh` untuk init yang robust
- Semicolon separator di entrypoint (bukan `&&` chain)
- Fallback untuk setiap artisan command

### ✅ .env.example
- `DB_CONNECTION` default ke `mysql` (bukan sqlite)
- Proper default values untuk semua config

### ✅ docker-entrypoint.sh (NEW)
- Clear caches dulu
- Run migrations dengan error handling
- Ensure PHP server selalu jalan
- Better logging & status updates

LOG_LEVEL=error
LOG_STDERR=true

MAIL_MAILER=log
```

## Build & Deployment Process

Railway akan otomatis:
1. Detect PHP project
2. Install Composer dependencies
3. Compile Node assets
4. Run migrations
5. Setup web server
6. Deploy & provide URL

## Troubleshooting Railway

### Cek Logs
```
Railway Dashboard → Deployment → Logs
```

### Force Rebuild
```powershell
git commit --allow-empty -m "Force rebuild"
git push
```

### SSH ke Railway (jika perlu)
```bash
railway shell
# Jalankan commands di hosting
php artisan tinker
```

## Custom Domain (Opsional)

1. Railway Dashboard → Project Settings
2. Domains → Add Custom Domain
3. Input domain Anda
4. Update DNS records sesuai instruksi Railway
