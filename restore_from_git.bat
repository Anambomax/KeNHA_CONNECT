@echo off
set DB_USER=root
set DB_NAME=kenha_connect
set DB_FILE=db\kenha_connect.db

REM === Auto-detect mysql.exe location ===
set MYSQL_PATH=%ProgramFiles%\xampp\mysql\bin\mysql.exe
if not exist "%MYSQL_PATH%" set MYSQL_PATH=C:\xampp\mysql\bin\mysql.exe
if not exist "%MYSQL_PATH%" (
    echo [ERROR] mysql.exe not found! Please update this script with the correct path.
    pause
    exit /b
)

REM === Git pull ===
echo Pulling latest changes from Git...
git pull origin project

REM === Restore database ===
echo Restoring MySQL database '%DB_NAME%' from '%DB_FILE%'...
"%MYSQL_PATH%" -u %DB_USER% -e "DROP DATABASE IF EXISTS %DB_NAME%; CREATE DATABASE %DB_NAME%;"
"%MYSQL_PATH%" -u %DB_USER% %DB_NAME% < %DB_FILE%

if %errorlevel% neq 0 (
    echo [ERROR] Failed to restore database.
) else (
    echo [SUCCESS] Database '%DB_NAME%' restored successfully from latest git sync.
)

pause
