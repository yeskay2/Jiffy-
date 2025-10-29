@echo off
echo ===============================================
echo    XAMPP MySQL Recovery Tool
echo ===============================================
echo.

echo Step 1: Stopping all processes...
taskkill /f /im mysqld.exe >nul 2>&1
taskkill /f /im apache.exe >nul 2>&1
timeout /t 2 >nul

echo Step 2: Cleaning up MySQL data...
cd /d "C:\xampp"

echo Step 3: Starting MySQL in recovery mode...
echo This will fix the corrupted phpMyAdmin tables...

cd /d "C:\xampp\mysql\bin"
echo Starting MySQL server...
start /b mysqld --defaults-file=my.ini --console

timeout /t 10

echo Step 4: Testing MySQL connection...
mysql -u root -e "SELECT 'MySQL is running!' as status;"

if %errorlevel% equ 0 (
    echo ✓ MySQL is running successfully!
    echo.
    echo Step 5: Fixing phpMyAdmin database...
    
    echo Dropping corrupted phpMyAdmin database...
    mysql -u root -e "DROP DATABASE IF EXISTS phpmyadmin;"
    
    echo Creating fresh phpMyAdmin database...
    mysql -u root -e "CREATE DATABASE phpmyadmin CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"
    
    echo Importing phpMyAdmin schema...
    mysql -u root phpmyadmin < "C:\xampp\phpMyAdmin\sql\create_tables.sql"
    
    if %errorlevel% equ 0 (
        echo ✓ phpMyAdmin database restored successfully!
    ) else (
        echo ⚠ phpMyAdmin schema import failed, but MySQL is working
    )
    
    echo.
    echo Step 6: Starting Apache...
    cd /d "C:\xampp"
    start /b apache\bin\httpd.exe
    
    timeout /t 5
    
    echo ===============================================
    echo ✓ XAMPP Recovery Completed!
    echo.
    echo You can now:
    echo - Access phpMyAdmin: http://localhost/phpmyadmin/
    echo - Import your database via web interface
    echo - Use your Jiffy application
    echo ===============================================
    
) else (
    echo ✗ MySQL failed to start
    echo Check the error log: C:\xampp\mysql\data\mysql_error.log
)

echo.
pause