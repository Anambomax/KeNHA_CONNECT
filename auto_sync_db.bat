@echo off
set DB_USER=root
set DB_NAME=kenha_connect
set DUMP_PATH=db\kenha_connect.db

echo Exporting MySQL database '%DB_NAME%' to '%DUMP_PATH%'
"C:\Desktop\xampp\mysql\bin\mysqldump.exe" -u %DB_USER% %DB_NAME% > %DUMP_PATH%

if %errorlevel% neq 0 (
    echo [ERROR] MySQL dump failed!
    pause
    exit /b
)

echo Pulling latest Git changes...
git pull origin project

git add %DUMP_PATH%
git diff --cached --quiet %DUMP_PATH%
if %errorlevel% neq 0 (
    git commit -m "Auto-sync: Updated database snapshot"
    git push origin project
    echo [SUCCESS] DB changes committed and pushed.
) else (
    echo [INFO] No changes in DB dump.
)

pause
