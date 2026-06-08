# 🆘 Troubleshooting Guide - PR #4 Deployment Issues

## 🔍 Diagnostic Flow

```
App not working?
    ↓
    Check Railway status → Green or Red?
    ├─ RED → Build/Runtime Error (see below)
    ├─ GREEN → App running but something broken (see below)
    
Got error message?
    ↓
    Search this guide for keywords
    ├─ "Access denied"
    ├─ "Healthcheck"
    ├─ ".env not found"
    ├─ Etc.
```

---

## 🔴 Build Failed (Railway Status: Failed)

### Symptoms
- Railway dashboard shows **Build Failed**
- Deploy never completes
- Build logs visible in Railway

### Troubleshooting

#### ❌ "npm ci failed" or "npm install failed"
```bash
# Problem: Node dependencies not installing
# Check: package-lock.json exists and valid

# Solution:
git checkout package-lock.json
git add package.json package-lock.json
git commit -m "Fix: package-lock.json"
git push
```

#### ❌ "composer install failed"
```bash
# Problem: PHP dependencies not installing
# Check: composer.lock exists and valid

# Solution:
git checkout composer.lock
git add composer.json composer.lock
git commit -m "Fix: composer.lock"
git push
```

#### ❌ "Dockerfile syntax error"
```bash
# Problem: Invalid Dockerfile syntax
# Solution: Check Dockerfile format

# Test locally:
docker build -t test .

# Common issues:
# - Missing newline after RUN command
# - Invalid ENTRYPOINT syntax
# - Missing FROM statement
```

#### ❌ "Permission denied" during build
```bash
# Problem: docker-entrypoint.sh not executable
# Solution:
git update-index --chmod=+x docker-entrypoint.sh
git commit -m "Fix: entrypoint executable permissions"
git push
```

---

## 🟠 Build Success but App Not Responding (Status: Running but Unhealthy)

### Symptoms
- Build succeeds (Railway shows "Build Complete")
- Container starts but status shows **Unhealthy** or **Crashed**
- Healthcheck failing

### Step 1: Check Logs
```bash
railway logs
```

#### Expected Output (✅ Healthy)
```
🚀 Starting Hulahup App initialization...
📝 Creating .env from .env.example...
🔑 Checking APP_KEY...
🔍 Checking database connection...
✅ Database is reachable
🧹 Clearing application caches...
🗄️  Running database migrations...
✅ Database migrations completed successfully
⚙️  Building application caches...
🌐 Starting PHP server on 0.0.0.0:8000...
```

#### Problem: "Creating .env from .env.example" then crashes

**Issue:** Entrypoint script errored

```bash
# Solution 1: Check if .env.example exists in git
git ls-files | grep ".env"
# Should see:
# .env.example

# Solution 2: Ensure .env.example committed
git add .env.example
git commit -m "Add: .env.example"
git push
```

#### Problem: "Generating APP_KEY..." then hangs/crashes

**Issue:** APP_KEY generation failed

```bash
# This shouldn't happen (has fallback), but if it does:
# Try regenerating locally and pushing new key

php artisan key:generate --show
# Copy the key (starts with "base64:")

# In .env.example:
APP_KEY=base64:your-generated-key-here

git add .env.example
git commit -m "Update: APP_KEY in .env.example"
git push
```

#### Problem: "Waiting for database..." then timeout

**Issue:** Database not responding within 30 seconds

```bash
# Check 1: Is MySQL plugin added to Railway?
# Go to Railway Dashboard → Check if MySQL service exists

# Check 2: Database credentials correct?
railway logs --service mysql
# Look for any MySQL errors

# Check 3: Network connectivity?
# Railway services should auto-connect
# Verify DB_HOST, DB_PORT in environment

# Solution: Restart deployment
# Railway Dashboard → Redeploy button
```

#### Problem: "Permission denied" when clearing caches

**Issue:** Storage directory not writable

```bash
# This should be fixed by Dockerfile, but if not:
railway shell

# Check permissions
ls -la storage/
# Should show: drwxrwxr-x (775 permissions)

# Fix permissions manually:
chmod -R 775 storage bootstrap/cache
chmod -R 775 storage/framework

# Then test
php artisan cache:clear
```

#### Problem: "SQLSTATE[HY000] [2002]" - Database connection error

**Issue:** MySQL credentials wrong or database not responding

```bash
# Check 1: Credentials are set
railway shell
env | grep DB_

# Check 2: Test connection
php -r "
\$host = getenv('DB_HOST');
\$user = getenv('DB_USER');
\$pass = getenv('DB_PASSWORD');
\$db = getenv('DB_NAME');
echo \"Trying to connect to \$host as \$user...\n\";
\$conn = new mysqli(\$host, \$user, \$pass, \$db);
if (\$conn->connect_error) {
    echo \"ERROR: \" . \$conn->connect_error;
} else {
    echo \"✅ Connected!\";
}
"

# Check 3: MySQL service running?
railway logs --service mysql
# Should see MySQL logs, not errors

# Solution: Restart MySQL service in Railway
# Railway Dashboard → MySQL service → Redeploy
```

---

## 🟢 Build Success, App Running (Status: Healthy) but Features Broken

### Symptoms
- Railway shows **Healthy** status ✅
- App accessible
- But specific features not working

#### ❌ "404 Not Found" on homepage

**Issue:** Routing not working

```bash
railway shell
php artisan route:list
# Should list all routes

# If empty, cache issue:
php artisan route:clear
php artisan route:cache

# If still broken, check:
php artisan tinker
>>> Route::list();
```

#### ❌ "Column not found" - Database error

**Issue:** Migration didn't run or failed

```bash
# Check migrations
railway shell
php artisan migrate:status
# Should show all migrations as "Ran"

# If some show as "Pending":
php artisan migrate --force

# If migration fails, check:
php artisan migrate --step --force
# Run migrations one by one to find which fails
```

#### ❌ "No table" errors

**Issue:** Database doesn't exist or migrations not run

```bash
# Check database exists
railway shell
mysql -u $DB_USER -p$DB_PASSWORD -e "SHOW DATABASES;"
# Should show your database name

# Check tables
mysql -u $DB_USER -p$DB_PASSWORD $DB_NAME -e "SHOW TABLES;"
# Should list users, orders, canteens, etc.

# If no tables, run migrations:
php artisan migrate --force
```

#### ❌ "Upload failed" - File storage issue

**Issue:** Storage directory not writable or not linked

```bash
# Check storage link
railway shell
ls -la public/
# Should have "storage" symlink or "storage" directory

# Create storage link:
php artisan storage:link

# Verify permissions:
chmod -R 775 storage
```

#### ❌ "CORS error" - API requests blocked

**Issue:** CORS configuration missing

```bash
# Check .env has correct APP_URL
railway shell
cat .env | grep APP_URL
# Should match your Railway domain

# If wrong, update in Railway:
# Railway Dashboard → Variables → Update APP_URL
# Then Redeploy

# Test CORS headers:
curl -I https://your-app.railway.app
```

#### ❌ Slow performance

**Issue:** Caches not enabled

```bash
# Check cache status
railway shell
php artisan tinker
>>> config('cache.default');
# Should show 'database'

# Enable all caches:
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Verify caches created:
ls -la bootstrap/cache/
ls -la storage/framework/cache/
```

---

## 🐛 Healthcheck Failing (Status: Unhealthy)

### Symptoms
- Container running but status shows "Unhealthy"
- Constant restarts
- Healthcheck logs show failures

### What is Healthcheck?

```dockerfile
HEALTHCHECK --interval=30s --timeout=10s --start-period=40s --retries=3 \
    CMD curl -f http://localhost:${PORT:-8000}/ || exit 1
```

Means:
- Every 30 seconds, try to access `http://localhost:8000/`
- If no response in 10 seconds → count as failure
- After starting, wait 40 seconds before first check (app startup time)
- After 3 failures → restart container

### Debug Healthcheck

#### Step 1: Check if PHP server listening

```bash
railway shell
netstat -tlnp | grep php
# or
ss -tlnp | grep php
# Should show: tcp 0 0 0.0.0.0:8000 LISTEN
```

**If not listening:**
- Entrypoint script didn't complete
- Check `railway logs` for errors
- PHP crashed → check `storage/logs/laravel.log`

#### Step 2: Test HTTP connection manually

```bash
railway shell
curl -v http://localhost:8000/
# Should get HTTP 200 or 302 (redirect)
# Not: Connection refused or timeout
```

**If "Connection refused":**
- PHP server not running → see Step 1

**If timeout:**
- PHP server hanging → likely infinite loop or waiting for something
- Kill PHP and restart:
  ```bash
  pkill php
  exit  # Exit railway shell
  # Railway auto-restarts container
  ```

#### Step 3: Check error logs

```bash
railway shell
tail -50 storage/logs/laravel.log
# Look for errors during initialization

tail -50 storage/logs/laravel.log | grep -i error
# See only error lines
```

#### Step 4: Check if homepage accessible

```bash
# From your local machine (not in railway shell):
curl https://your-app.railway.app/
# Should get HTML response

# If 500 error:
railway shell
php artisan tinker
>>> request()->getRequestUri();
>>> view('welcome');  # Test main view rendering
```

### Common Healthcheck Failures

#### ❌ "Connection refused"
```
Cause: PHP server not running
Solution: Check Step 1 above
```

#### ❌ "Timeout" (hangs)
```
Cause: PHP processing request takes > 10 seconds
Solution: Optimize code, or increase timeout in Dockerfile:
HEALTHCHECK --timeout=30s ...
```

#### ❌ "HTTP 500"
```
Cause: App error when rendering homepage
Solution:
  railway shell
  php artisan tinker
  >>> view('welcome');
  # Should render without error
```

---

## 🔄 Restart & Redeploy Strategies

### Quick Restart (Keep current code)
```bash
railway service restart
# Container restarts, runs initialization again
```

### Full Redeploy (Rebuild from code)
```bash
# Option 1: Via Railway UI
# Go to Railway → Deployments → Click latest → Redeploy

# Option 2: Via CLI
railway up

# Option 3: Push dummy commit to trigger auto-deploy
git commit --allow-empty -m "Trigger: Force redeploy"
git push
```

### Rollback to Previous Version
```bash
# Railway Dashboard → Deployments tab
# Click on previous deployment → Redeploy from that version
```

---

## 📋 Debugging Checklist

```bash
# 1. Check logs
railway logs | head -30

# 2. Check service status
railway status

# 3. Check environment variables
railway shell
env | grep -E 'APP_|DB_'

# 4. Check critical files
ls -la .env
ls -la storage/logs/laravel.log

# 5. Test database
php artisan tinker
>>> DB::connection()->getPdo();

# 6. Test routing
php artisan route:list

# 7. Check PHP extensions
php -m | grep pdo

# 8. Check permissions
ls -la storage bootstrap/cache

# 9. Check Laravel config
php artisan config:show APP

# 10. Look for errors
grep -i error storage/logs/laravel.log | tail -20
```

---

## 📞 Getting Help

### Collect Diagnostic Info
```bash
# Save these to share with team:

# 1. Last 50 log lines
railway logs | tail -50 > logs.txt

# 2. Environment check
railway shell
env | grep -E 'APP_|DB_' > env_check.txt

# 3. Status
railway status > status.txt

# 4. Recent deployments
# (From Railway Dashboard → screenshot)
```

### Common Issues Reference

| Error | Likely Cause | Solution |
|-------|--------------|----------|
| Access denied for user '' | `.env` not read | Check `.env` exists, has DB credentials |
| No application encryption key | APP_KEY not set | Should auto-generate, check logs |
| SQLSTATE HY000 | Database unreachable | Check DB_HOST, DB_PORT, DB credentials |
| Permission denied storage | Wrong permissions | `chmod -R 775 storage bootstrap/cache` |
| Column not found | Migration not run | `php artisan migrate --force` |
| Healthcheck timeout | PHP not responding | Check PHP running, see logs |
| 404 Not Found | Routes not cached or broken | `php artisan route:cache` |
| Out of memory | PHP memory limit | Increase `memory_limit` in php.ini |

---

## 🚀 Escalation Path

| Issue Level | Action | Escalate If |
|-------------|--------|-------------|
| Minor (slow, warning logs) | Check logs, optimize code | Persists > 1 day |
| Medium (feature broken, 500 error) | Debug with checklist above | Can't identify cause |
| Critical (app down, healthcheck failing) | Restart service, check logs | Still broken after restart |
| Emergency | Rollback to previous deploy | Blocking prod, users affected |

---

## 📚 Related Resources

- [PR #4 Summary](PR4_SUMMARY.md)
- [Railway Deployment Guide](RAILWAY_DEPLOYMENT_PR4.md)
- [Quick Deploy Guide](QUICK_DEPLOY_GUIDE.md)
- [Deployment Checklist](DEPLOYMENT_CHECKLIST.json)

---

**Last Updated:** PR #4 - June 8, 2026  
**Status:** ✅ Comprehensive Troubleshooting Guide

