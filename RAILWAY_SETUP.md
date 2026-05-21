# Railway.app Configuration untuk Hulahup App

## Procfile
```
web: vendor/bin/heroku-php-apache2 public/
release: php artisan migrate --force
```

## Jalankan Migrations Otomatis

Buat file: `railway.json`
```json
{
  "$schema": "https://railway.app/railway.schema.json",
  "build": {
    "builder": "nixpacks"
  },
  "deploy": {
    "restartPolicyType": "on_failure",
    "restartPolicyMaxRetries": 5,
    "startCommand": "php artisan migrate --force && php artisan config:cache && vendor/bin/heroku-php-apache2 public/"
  }
}
```

## Environment Variables untuk Railway

Setup di Railway Dashboard → Project → Variables:

```
APP_NAME=HulahupApp
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:WAPd7wVwBvqGdWldN+8YmdE+ivk7pzg0CWXaAXi3MnE=
APP_URL=${{RAILWAY_PUBLIC_DOMAIN}}

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
BROADCAST_CONNECTION=log

LOG_CHANNEL=stack
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
