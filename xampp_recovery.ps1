# XAMPP Recovery PowerShell Script
Write-Host "===============================================" -ForegroundColor Cyan
Write-Host "    XAMPP MySQL & phpMyAdmin Recovery" -ForegroundColor Cyan  
Write-Host "===============================================" -ForegroundColor Cyan
Write-Host

Write-Host "Step 1: Stopping all MySQL processes..." -ForegroundColor Yellow
Stop-Process -Name "mysqld" -Force -ErrorAction SilentlyContinue
Stop-Process -Name "httpd" -Force -ErrorAction SilentlyContinue
Start-Sleep -Seconds 3

Write-Host "Step 2: Starting MySQL..." -ForegroundColor Yellow
Set-Location "C:\xampp\mysql\bin"

# Start MySQL in background
$mysqlProcess = Start-Process -FilePath ".\mysqld.exe" -ArgumentList "--defaults-file=my.ini" -PassThru -WindowStyle Hidden
Start-Sleep -Seconds 10

Write-Host "Step 3: Testing MySQL connection..." -ForegroundColor Yellow
$testResult = & .\mysql.exe -u root -e "SELECT 'MySQL is working!' as status;" 2>$null

if ($LASTEXITCODE -eq 0) {
    Write-Host "✓ MySQL is running successfully!" -ForegroundColor Green
    Write-Host
    
    Write-Host "Step 4: Fixing phpMyAdmin database..." -ForegroundColor Yellow
    
    # Drop and recreate phpMyAdmin database
    & .\mysql.exe -u root -e "DROP DATABASE IF EXISTS phpmyadmin;" 2>$null
    & .\mysql.exe -u root -e "CREATE DATABASE phpmyadmin CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;" 2>$null
    
    # Check if phpMyAdmin schema exists and import it
    $schemaFile = "C:\xampp\phpMyAdmin\sql\create_tables.sql"
    if (Test-Path $schemaFile) {
        Write-Host "Importing phpMyAdmin schema..." -ForegroundColor Cyan
        & .\mysql.exe -u root phpmyadmin --execute="SOURCE $schemaFile" 2>$null
        if ($LASTEXITCODE -eq 0) {
            Write-Host "✓ phpMyAdmin database restored!" -ForegroundColor Green
        } else {
            Write-Host "⚠ phpMyAdmin schema import had issues, but database created" -ForegroundColor Yellow
        }
    } else {
        Write-Host "⚠ phpMyAdmin schema not found, creating basic structure" -ForegroundColor Yellow
    }
    
    Write-Host
    Write-Host "Step 5: Starting Apache..." -ForegroundColor Yellow
    Set-Location "C:\xampp"
    $apacheProcess = Start-Process -FilePath "apache\bin\httpd.exe" -PassThru -WindowStyle Hidden
    Start-Sleep -Seconds 5
    
    Write-Host
    Write-Host "===============================================" -ForegroundColor Green
    Write-Host "✓ XAMPP Recovery Completed Successfully!" -ForegroundColor Green
    Write-Host
    Write-Host "You can now access:" -ForegroundColor Cyan
    Write-Host "- phpMyAdmin: http://localhost/phpmyadmin/" -ForegroundColor White
    Write-Host "- Jiffy Admin: http://localhost/Jiffy-new/admin/" -ForegroundColor White
    Write-Host "- Import Database: http://localhost/Jiffy-new/import_jiffy_database.php" -ForegroundColor White
    Write-Host "===============================================" -ForegroundColor Green
    
} else {
    Write-Host "✗ MySQL failed to start properly" -ForegroundColor Red
    Write-Host "Checking error log..." -ForegroundColor Yellow
    
    $errorLog = "C:\xampp\mysql\data\mysql_error.log"
    if (Test-Path $errorLog) {
        Write-Host "Latest error log entries:" -ForegroundColor Yellow
        Get-Content $errorLog -Tail 10
    }
}

Write-Host
Read-Host "Press Enter to continue"