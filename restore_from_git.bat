@echo off
set DB_USER=root
set DB_NAME=kenha_connect
set DB_FILE=db\kenha_connect.db

echo Pulling latest project updates...
git pull origin project

echo Restoring MySQL database '%DB_NAME%' from '%DB_FILE%'...
"C:\Desktop\xampp\mysql\bin\mysql.exe" -u %DB_USER% -e "DROP DATABASE IF EXISTS %DB_NAME%; CREATE DATABASE %DB_NAME%;"
"C:\Desktop\xampp\mysql\bin\mysql.exe" -u %DB_USER% %DB_NAME% < %DB_FILE%

if %errorlevel% neq 0 (
    echo [ERROR] Failed to restore database.
) else (
    echo [SUCCESS] Database '%DB_NAME%' restored successfully.
)

pause
