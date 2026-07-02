@echo off
REM SETUP DATABASE KEZISTORE - Windows Version
REM Run this script to setup the database properly

echo.
echo ====================================
echo  KEZISTORE Database Setup
echo ====================================
echo.

REM 1. Check .env file
echo [1/6] Checking .env configuration...
if not exist .env (
    echo Creating .env file from .env.example...
    copy .env.example .env
    call php artisan key:generate
)
echo ✓ .env checked

REM 2. Run migrations
echo.
echo [2/6] Running migrations...
call php artisan migrate --force
if %errorlevel% equ 0 (
    echo ✓ Migrations completed
) else (
    echo ✗ Migration failed - check your database connection
    pause
    exit /b 1
)

REM 3. Create required directories
echo.
echo [3/6] Creating required directories...
if not exist public\bukti mkdir public\bukti
if not exist public\foto mkdir public\foto
if not exist storage\app\public mkdir storage\app\public
echo ✓ Directories created

REM 4. Link storage (Laravel command)
echo.
echo [4/6] Linking storage...
call php artisan storage:link
echo ✓ Storage linked

REM 5. Clear cache
echo.
echo [5/6] Clearing cache...
call php artisan cache:clear
call php artisan config:cache
echo ✓ Cache cleared

echo.
echo ====================================
echo  ✓ Setup Completed Successfully!
echo ====================================
echo.
echo Next Steps:
echo 1. Start server: php artisan serve
echo 2. Open: http://localhost:8000
echo 3. Login with credentials
echo.
pause
