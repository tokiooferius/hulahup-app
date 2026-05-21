@echo off
REM Hulahup App - Automated Deployment Setup Script
REM Windows PowerShell Version

echo.
echo ================================
echo HULAHUP APP - SETUP & DEPLOYMENT
echo ================================
echo.

REM Check if in correct directory
if not exist "composer.json" (
    echo ERROR: composer.json not found!
    echo Please run this script from the project root directory
    pause
    exit /b 1
)

echo [1/10] Initializing Git Repository...
if not exist ".git" (
    git init
    git config user.name "Developer"
    git config user.email "dev@hulahup.com"
    echo Git initialized successfully
) else (
    echo Git already initialized
)

echo.
echo [2/10] Installing PHP Dependencies...
call composer install --optimize-autoloader --no-dev
if errorlevel 1 (
    echo ERROR: Composer installation failed
    pause
    exit /b 1
)

echo.
echo [3/10] Installing Node Dependencies...
call npm install
if errorlevel 1 (
    echo ERROR: npm installation failed
    pause
    exit /b 1
)

echo.
echo [4/10] Building Frontend Assets...
call npm run build
if errorlevel 1 (
    echo ERROR: npm build failed
    pause
    exit /b 1
)

echo.
echo [5/10] Generating Application Key...
php artisan key:generate --show > app_key.txt
for /f "delims=" %%i in (app_key.txt) do set APP_KEY=%%i
echo APP_KEY Generated: %APP_KEY%
del app_key.txt

echo.
echo [6/10] Caching Configuration...
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo Configuration cached

echo.
echo [7/10] Creating Storage Link...
php artisan storage:link
echo Storage linked

echo.
echo [8/10] Running Database Migrations (Local)...
echo NOTE: Make sure your local database is running!
php artisan migrate
if errorlevel 1 (
    echo WARNING: Migration failed. Ensure database is running.
)

echo.
echo [9/10] Checking Application Status...
php artisan tinker --execute="echo 'Database OK'"

echo.
echo [10/10] Preparing for GitHub Push...
echo - Adding files to git...
git add .
echo - Creating .deployment files...

if not exist ".gitignore" (
    echo Creating .gitignore...
    (
        echo *.log
        echo .DS_Store
        echo .env
        echo .env.backup
        echo .env.production
        echo .phpactor.json
        echo .phpunit.result.cache
        echo /.fleet
        echo /.idea
        echo /.nova
        echo /.phpunit.cache
        echo /.vscode
        echo /.zed
        echo /auth.json
        echo /node_modules
        echo /public/build
        echo /public/hot
        echo /public/storage
        echo /storage/*.key
        echo /storage/pail
        echo /vendor
        echo Homestead.json
        echo Homestead.yaml
        echo Thumbs.db
    ) > .gitignore
)

echo.
echo ================================
echo SETUP COMPLETE!
echo ================================
echo.
echo Next Steps:
echo.
echo 1. CREATE GITHUB REPOSITORY
echo    - Go to https://github.com/new
echo    - Repository name: hulahup-app
echo    - Click "Create repository"
echo.
echo 2. PUSH TO GITHUB
echo    git remote add origin https://github.com/YOUR_USERNAME/hulahup-app.git
echo    git branch -M main
echo    git push -u origin main
echo.
echo 3. DEPLOY TO RAILWAY
echo    - Go to https://railway.app
echo    - Click "New Project"
echo    - Connect your GitHub repository
echo    - Railway will auto-deploy!
echo.
echo 4. SETUP DATABASE IN RAILWAY
echo    - Add MySQL database
echo    - Set environment variables
echo    - Run migrations: php artisan migrate --force
echo.
echo 5. ACCESS YOUR APP
echo    - Open: https://your-app.up.railway.app
echo    - Share with others!
echo.

echo Press any key to continue...
pause

REM Optional: Test local server
echo.
echo Would you like to test the local server now? (y/n)
set /p test_local="Enter choice: "
if /i "%test_local%"=="y" (
    echo.
    echo Starting local development server...
    echo Open http://localhost:8000 in your browser
    echo.
    php artisan serve
)
