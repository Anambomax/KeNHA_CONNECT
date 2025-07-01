@echo off
set DB_NAME=kenha_connect
set DB_USER=root
set DB_PASS=
set MYSQLDUMP_PATH="C:\xampp\mysql\bin\mysqldump.exe"
set OUTPUT_PATH=db\%DB_NAME%.db

echo Exporting MySQL database '%DB_NAME%' to '%OUTPUT_PATH%'

%MYSQLDUMP_PATH% -u %DB_USER% %DB_NAME% > %OUTPUT_PATH%

IF %ERRORLEVEL% NEQ 0 (
    echo [ERROR] MySQL dump failed!
    pause
    exit /b
)

git add %OUTPUT_PATH%
git commit -m "Auto-sync: Updated database snapshot"
git pull
git push

echo [SUCCESS] DB changes committed and pushed.
pause
