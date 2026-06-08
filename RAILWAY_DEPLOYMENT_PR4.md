# 🚀 Railway Deployment Guide - PR #4: Robust Docker & Environment Setup

## 📋 Overview

PR #4 memastikan aplikasi Laravel bisa di-deploy ke Railway dengan **aman**, **robust**, dan **scalable**.

### ✅ Masalah yang Diperbaiki

| Masalah | Penyebab | Solusi |
|---------|---------|--------|
| `.env` tidak ada | Laravel membutuhkan file konfigurasi | Copy `.env.example` saat build time |
| Database credentials kosong | Environment variables belum terbaca | Read dari Railway environment variables |
| Migration gagal, app crash | CMD chain dengan `&&` → seluruh proses berhenti | Entrypoint script dengan fallback & error handling |
| Healthcheck timeout | Server tidak jalan jika migration gagal | Ensure PHP server selalu start |
| APP_KEY tidak generate | Tanpa APP_KEY, app tidak bisa encrypt | Generate APP_KEY di build time & runtime |

---

## 🔧 Perubahan yang Dilakukan

### 1. **Dockerfile** - Build Time Configuration

```dockerfile
# Copy .env dari .env.example (production-ready defaults)
RUN cp .env.example .env || true

# Generate APP_KEY selama build jika belum ada
RUN php artisan key:generate --no-interaction --force || true

# Create storage directories dengan permission yang correct
RUN mkdir -p storage/framework/{sessions,views,cache/data} \
             storage/logs \
             bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Add HEALTHCHECK untuk monitoring deployment
HEALTHCHECK --interval=30s --timeout=10s --start-period=40s --retries=3 \
    CMD curl -f http://localhost:${PORT:-8000}/ || exit 1

# Use entrypoint script untuk robust initialization
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
```

### 2. **docker-entrypoint.sh** - Runtime Initialization

```bash
#!/bin/sh
# ✅ Robust error handling
# ✅ Database connection checking
# ✅ Cache management
# ✅ Non-blocking migration (app starts even jika migration fail)
# ✅ PHP server selalu berjalan
```

**Key Features:**

- **Ensure `.env` exists** - Copy dari `.env.example` jika belum ada
- **APP_KEY generation** - Generate jika belum ada (untuk encryption)
- **Database connection check** - Wait hingga 30 detik untuk database ready
- **Clear caches first** - Important untuk perubahan environment variable
- **Run migrations** - Dengan non-blocking fallback
- **Build caches** - Config, route, view caching untuk production
- **Start PHP server** - **SELALU START**, bahkan jika migration gagal
- **Logging** - Detailed logging untuk debugging

### 3. **`.env.example`** - Production-Ready Defaults

```env
APP_NAME="Hulahup App"
APP_ENV=production          # ✅ Production environment
APP_DEBUG=false             # ✅ Debug disabled
APP_URL=https://your-domain.railway.app

# Database - support Railway environment variables
DB_CONNECTION=mysql
DB_HOST=${DB_HOST:-127.0.0.1}
DB_PORT=${DB_PORT:-3306}
DB_DATABASE=${DB_NAME:-hulahup_db}
DB_USERNAME=${DB_USER:-root}
DB_PASSWORD=${DB_PASSWORD:-}

# Logging - error level untuk production
LOG_LEVEL=error

# Lokalisasi - Indonesian defaults
APP_LOCALE=id
APP_FALLBACK_LOCALE=en
```

---

## 🚆 Railway Environment Setup

### Step 1: Create Railway Service

```bash
# Login ke Railway
railway login

# Link project ke Railway
railway link
```

### Step 2: Add MySQL Database

**Via Railway Dashboard:**

1. Go to **Plugins** → Add **MySQL**
2. Railway automatically sets:
   - `DB_HOST` → database hostname
   - `DB_PORT` → 3306
   - `DB_NAME` → database name
   - `DB_USER` → database username
   - `DB_PASSWORD` → secure password

### Step 3: Configure Environment Variables

**Via Railway Dashboard** → **Variables**:

```env
# Laravel Configuration
APP_NAME=Hulahup App
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-hulahup-app.railway.app

# Locale
APP_LOCALE=id

# Logging
LOG_LEVEL=error
LOG_CHANNEL=stack

# Queue & Cache (using database)
QUEUE_CONNECTION=database
CACHE_STORE=database

# Session
SESSION_DRIVER=database

# Database credentials are auto-set by Railway MySQL plugin
# No need to set DB_HOST, DB_PORT, DB_NAME, DB_USER, DB_PASSWORD manually
```

### Step 4: Configure Dockerfile

Railway harus tahu port yang digunakan. Di Dockerfile kita sudah set:

```dockerfile
EXPOSE 8000
```

Railway otomatis set `PORT` environment variable (default: 8000).

### Step 5: Deploy

```bash
# Push ke Railway
git push
```

Atau via Railway CLI:

```bash
railway up
```

---

## 🔍 Deployment Flow (Diagram)

```
┌─────────────────────┐
│  Docker Build Phase │
└──────────┬──────────┘
           ↓
    1. Copy .env.example → .env
    2. Generate APP_KEY (if needed)
    3. Create storage directories
    4. Set permissions (775)
    5. Copy entrypoint script
           ↓
    ✅ Build successful
           │
           ↓
┌─────────────────────┐
│ Runtime - Container │
│    Starts Up        │
└──────────┬──────────┘
           ↓
    1. Check .env exists
    2. Verify APP_KEY
    3. Clear caches
    4. Wait for database (30s max)
           ↓
    5. Run migrations
       ├─ Success ✅
       ├─ Already synced ✅
       └─ Fail → Log warning ⚠️ but continue!
           ↓
    6. Build caches
       ├─ Config cache
       ├─ Route cache
       └─ View cache
           ↓
    7. Start PHP server on 0.0.0.0:8000
           ↓
    ✅ App ready!
       └─ HEALTHCHECK starts monitoring
```

---

## 📊 Monitoring & Debugging

### Check Logs

```bash
# View real-time logs
railway logs

# View service logs
railway service logs

# View build logs
railway build logs
```

### Healthcheck Status

Railway automatically runs HEALTHCHECK every 30s:

```dockerfile
HEALTHCHECK --interval=30s --timeout=10s --start-period=40s --retries=3 \
    CMD curl -f http://localhost:${PORT:-8000}/ || exit 1
```

- **Start Period**: 40s (give app time to initialize)
- **Interval**: Check every 30s
- **Timeout**: 10s per check
- **Retries**: 3 failures before restart

### Common Issues & Solutions

| Issue | Cause | Solution |
|-------|-------|----------|
| Healthcheck failing | App not responding | Check `railway logs` for startup errors |
| Migration errors | Database not ready | Entrypoint waits 30s; check DB credentials |
| `.env` not found | Build issue | Ensure `.env.example` in git repo |
| APP_KEY not set | Build skip or generation fail | Should be auto-generated during build |
| Port conflict | Another service on 8000 | Set `PORT` environment variable |

---

## 🔐 Security Best Practices

### What NOT to Do

❌ **NEVER** commit `.env` file to git (contains secrets)
❌ **NEVER** hardcode passwords in Dockerfile
❌ **NEVER** disable `APP_DEBUG` in production
❌ **NEVER** use `root` credentials for production DB

### What TO Do

✅ **DO** use Railway's environment variable system
✅ **DO** keep `.env.example` without secrets (safe to commit)
✅ **DO** rotate `APP_KEY` regularly
✅ **DO** use strong database passwords
✅ **DO** enable HTTPS (Railway provides SSL)
✅ **DO** set `LOG_LEVEL=error` for production

### Environment Variables Setup

**Local Development** (`.env`):
```env
APP_ENV=local
APP_DEBUG=true
DB_HOST=127.0.0.1
DB_PASSWORD=local_password
```

**Production** (Railway Variables):
```env
APP_ENV=production
APP_DEBUG=false
# DB credentials auto-set by Railway MySQL plugin
```

---

## 📋 Deployment Checklist

### Before Deployment

- [ ] All tests passing locally
- [ ] `.env.example` has production-ready defaults
- [ ] Sensitive data removed from `.env.example`
- [ ] Dockerfile builds successfully locally
- [ ] `docker-entrypoint.sh` is executable (`chmod +x`)
- [ ] All migrations are up-to-date
- [ ] Frontend assets built (`npm run build`)
- [ ] No secrets in git history

### Railway Setup

- [ ] Railway account created
- [ ] Project linked (`railway link`)
- [ ] MySQL database added via Railway
- [ ] Environment variables configured
- [ ] `PORT` set to 8000 (or configured)
- [ ] Deploy trigger configured (auto-deploy on push)

### Post-Deployment

- [ ] Access application at Railway URL
- [ ] Check `railway logs` for errors
- [ ] Verify database migrations ran
- [ ] Test key functionality (login, create order, etc.)
- [ ] Monitor healthcheck status
- [ ] Set up monitoring alerts (optional)

---

## 🆘 Troubleshooting

### App Container Keeps Restarting

**Symptoms**: Container exits with code 1, restarts repeatedly

**Debug**:
```bash
railway logs
```

**Common Causes:**
1. Database connection fail → Wait 30s and retry automatically
2. Missing `.env` → Check entrypoint script, should copy automatically
3. APP_KEY not set → Should be generated automatically
4. Permissions issue → Check `chmod 775 storage bootstrap/cache`

**Solution**:
```bash
# SSH into Railway container
railway shell

# Check .env exists
ls -la .env

# Check logs
tail -f storage/logs/laravel.log

# Manually test database connection
php artisan tinker
>>> \DB::connection()->getPdo();
```

### Database Connection Fails

**Check Railway MySQL credentials:**
```bash
railway logs --service mysql
```

**Verify environment variables in container:**
```bash
railway shell
env | grep DB_
```

**Connection test:**
```bash
# Inside container
php -r "
\$host = getenv('DB_HOST');
\$port = getenv('DB_PORT');
\$user = getenv('DB_USER');
\$pass = getenv('DB_PASSWORD');
\$db = getenv('DB_NAME');

echo \"Connecting to \$host:\$port...\n\";
\$conn = new mysqli(\$host, \$user, \$pass, \$db, \$port);
if (\$conn->connect_error) {
    echo \"ERROR: \" . \$conn->connect_error;
} else {
    echo \"✅ Connected!\n\";
}
"
```

### Healthcheck Failing

**Check service status:**
```bash
railway status
```

**Manually test healthcheck:**
```bash
railway shell
curl -f http://localhost:8000/ -v
```

**If app responds but healthcheck fails:**
1. Check PHP server is listening on 0.0.0.0 (not 127.0.0.1)
2. Check `start-period=40s` is enough time
3. Increase `timeout=10s` if needed

---

## 📚 Related Documentation

- [Railway Documentation](https://docs.railway.app)
- [Laravel Deployment](https://laravel.com/docs/11.x/deployment)
- [Docker Best Practices](https://docs.docker.com/develop/dev-best-practices/)
- [MySQL on Railway](https://docs.railway.app/plugins/mysql)

---

## 🎉 Success Indicators

✅ **App is ready for production when:**

1. **Deployment succeeds** - No build errors
2. **Container starts** - Healthcheck passes
3. **Logs show initialization** - All steps in entrypoint executed
4. **Database connected** - Migrations ran successfully
5. **App responds** - Can access https://your-app.railway.app
6. **No errors** - `railway logs` shows clean startup
7. **Metrics healthy** - CPU/Memory usage normal

---

**Last Updated:** PR #4 - June 8, 2026  
**Author:** Hulahup Deployment Team  
**Status:** ✅ Production Ready
