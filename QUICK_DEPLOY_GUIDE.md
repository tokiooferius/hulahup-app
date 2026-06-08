# ⚡ QUICK DEPLOY GUIDE - Railway Deployment (PR #4)

## 🚀 Deploy in 5 Steps

### Step 1: Commit Code (2 min)
```bash
# Make sure you're on main branch
git checkout main

# Stage PR #4 changes
git add .

# Commit
git commit -m "PR #4: Robust Docker & Environment Setup

- Dockerfile: Auto-copy .env, generate APP_KEY, set permissions, add healthcheck
- docker-entrypoint.sh: Robust initialization with database check & non-blocking migration
- .env.example: Production-ready defaults with Railway env var support"

# Push to GitHub
git push origin main
```

### Step 2: Railway Setup (5 min)
1. Go to **https://railway.app**
2. Login with GitHub
3. Click **"New Project"** → **"Deploy from GitHub repo"**
4. Select **hulahup-app** repository
5. Wait for Railway to auto-detect Dockerfile
6. Click **Deploy** (Railway automatically builds & starts)

### Step 3: Add Database (2 min)
1. In Railway Dashboard → Click **"+"**
2. Search for **MySQL**
3. Click **"Create"**
4. Railway automatically links to your app

### Step 4: Set Environment Variables (3 min)
Go to Railway Dashboard → **Variables** tab:

```env
APP_NAME=Hulahup App
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.up.railway.app
APP_LOCALE=id
LOG_LEVEL=error
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

**Note:** `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASSWORD` are auto-set by MySQL plugin.

### Step 5: Verify Deployment (2 min)
1. Watch **Railway → Logs** (should see initialization messages)
2. Wait for status to turn **Green** ✅
3. Click **"Open App"** button
4. Test: Homepage loads, login works, database responds
5. **Success!** 🎉

---

## ✅ Expected Log Output

When deployment completes, you should see:

```
🚀 Starting Hulahup App initialization...
📝 Creating .env from .env.example...
✅ .env already exists
🔑 Checking APP_KEY...
✅ APP_KEY already set
🔍 Checking database connection...
⏳ Waiting for database at mysql-service:3306...
✅ Database is reachable
🧹 Clearing application caches...
🗄️  Running database migrations...
✅ Database migrations completed successfully
⚙️  Building application caches...
✅ Application initialization complete!
🌐 Starting PHP server on 0.0.0.0:8000...
```

**Green status ✅ = Deploy successful!**

---

## 🐛 If Something Goes Wrong

### ❌ Healthcheck Failing
```bash
# Check logs
railway logs

# Look for errors, common ones:
# - "Access denied for user" → Database not ready (will retry)
# - "Permission denied" → Migration failed (non-blocking, app continues)
# - "Connection refused" → PHP server didn't start (check logs)
```

### ❌ Build Failed
```bash
# Check build logs
railway build logs

# Common issues:
# - npm ci failed → Node dependency issue
# - composer install failed → PHP dependency issue
# - Dockerfile syntax → Check Dockerfile for errors
```

### ❌ App Not Responding
```bash
# Shell into container
railway shell

# Check if PHP server running
ps aux | grep php

# Check error logs
tail -f storage/logs/laravel.log

# Test database
php artisan tinker
>>> DB::connection()->getPdo();
```

---

## 🔄 Update & Redeploy

### Simple Code Update
```bash
git add .
git commit -m "Update: feature description"
git push
# Railway auto-deploys (watch Status indicator turn green)
```

### Database Changes (New Migration)
```bash
# 1. Create migration locally
php artisan make:migration add_column_to_table

# 2. Commit & push
git add database/migrations/
git commit -m "Migration: add column"
git push

# 3. Railway auto-runs migration via entrypoint script
# (no manual step needed!)
```

### Environment Variable Update
1. Go to Railway Dashboard → **Variables**
2. Update value (e.g., change `APP_URL`)
3. **IMPORTANT:** Click **Redeploy** button for changes to take effect
4. Wait for redeployment to complete (status turns green)

---

## 📊 Useful Railway Commands

```bash
# Login
railway login

# Link current project
railway link

# View logs
railway logs

# View service logs
railway logs --service hulahup-app

# Shell into container
railway shell

# View environment variables
railway status

# Rebuild & redeploy
railway up

# View real-time metrics
railway status -v
```

---

## 🎯 Common Tasks

### View Database
```bash
railway shell
mysql -h $DB_HOST -u $DB_USER -p$DB_PASSWORD $DB_NAME
# Inside mysql:
SELECT * FROM users;
```

### Run Database Command
```bash
railway shell
php artisan db:seed
php artisan cache:clear
php artisan tinker
```

### Check App Status
```bash
railway logs | head -50  # Last 50 lines
railway logs --tail 100  # Stream last 100 lines
```

### Check PHP Configuration
```bash
railway shell
php -i | grep "loaded configuration"
php -m | grep pdo  # Check if PDO extension loaded
```

---

## 🔒 Security Checklist

Before going live:
- ✅ `APP_DEBUG=false`
- ✅ `APP_ENV=production`
- ✅ `LOG_LEVEL=error` (not debug)
- ✅ Strong database password set
- ✅ `.env.example` has no secrets (safe to commit)
- ✅ HTTPS enabled (Railway provides)
- ✅ No API keys in environment (if applicable)

---

## 📞 Need Help?

| Issue | Resource |
|-------|----------|
| Railway docs | https://docs.railway.app |
| Laravel docs | https://laravel.com/docs |
| Docker info | https://docs.docker.com |
| Deployment logs | `railway logs` |
| PR #4 details | See [PR4_SUMMARY.md](PR4_SUMMARY.md) |
| Full guide | See [RAILWAY_DEPLOYMENT_PR4.md](RAILWAY_DEPLOYMENT_PR4.md) |

---

## ⏱️ Timeline Estimate

| Step | Time |
|------|------|
| Commit & push | 2 min |
| Railway setup | 5 min |
| Add database | 2 min |
| Set variables | 3 min |
| Build & deploy | 3-5 min |
| Verification | 2 min |
| **Total** | **~15-20 min** |

---

## 🎉 That's It!

After 20 minutes, your app is live on Railway with:
- ✅ Auto-initialized environment
- ✅ Running database migrations
- ✅ Production caches enabled
- ✅ Healthcheck monitoring
- ✅ Scalable infrastructure
- ✅ SSL/HTTPS included

**Happy deploying!** 🚀

