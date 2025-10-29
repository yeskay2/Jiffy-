@echo off
echo ===============================================
echo    Jiffy Database Import - Direct MySQL
echo ===============================================
echo.

cd /d "C:\xampp\htdocs\Jiffy-new"

echo Checking if pms.sql exists...
if not exist "pms.sql" (
    echo ERROR: pms.sql file not found!
    echo Please copy pms.sql to C:\xampp\htdocs\Jiffy-new\
    pause
    exit /b 1
)

echo ✓ Found pms.sql file
echo.

echo Connecting to MySQL and importing database...
echo This may take a few minutes for large databases...
echo.

cd /d "C:\xampp\mysql\bin"

echo Dropping existing pms database...
mysql -u root -e "DROP DATABASE IF EXISTS pms;"

echo Creating new pms database...
mysql -u root -e "CREATE DATABASE pms CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"

echo Importing pms.sql...
mysql -u root pms < "C:\xampp\htdocs\Jiffy-new\pms.sql"

if %errorlevel% equ 0 (
    echo.
    echo ✓ SUCCESS! Database imported successfully
    echo.
    echo Verifying import...
    mysql -u root -e "USE pms; SHOW TABLES; SELECT COUNT(*) as 'Total Tables' FROM information_schema.tables WHERE table_schema = 'pms';"
    echo.
    echo ===============================================
    echo Database import completed successfully!
    echo You can now use your Jiffy application.
    echo ===============================================
) else (
    echo.
    echo ✗ ERROR: Database import failed
    echo Check the error messages above
    echo ===============================================
)

echo.
pause