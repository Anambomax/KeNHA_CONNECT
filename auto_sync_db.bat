@echo off
set DB_USER=root
set DB_NAME=kenha_connect
set DUMP_PATH=db\kenha_connect.db

REM === Auto-detect mysqldump.exe location ===
set MYSQLDUMP_PATH=%ProgramFiles%\xampp\mysql\bin\mysqldump.exe
if not exist "%MYSQLDUMP_PATH%" set MYSQLDUMP_PATH=C:\xampp\mysql\bin\mysqldump.exe
if not exist "%MYSQLDUMP_PATH%" (
    echo [ERROR] mysqldump.exe not found! Please update this script with the correct path.
    pause
    exit /b
)

REM === Dump the database ===
echo Exporting MySQL database '%DB_NAME%' to '%DUMP_PATH%'
"%MYSQLDUMP_PATH%" -u %DB_USER% %DB_NAME% > %DUMP_PATH%

if %errorlevel% neq 0 (
    echo [ERROR] MySQL dump failed!
    pause
    exit /b
)

REM === Git pull, commit, and push ===
echo Pulling latest changes from Git...
git pull origin project

git add %DUMP_PATH%
git diff --cached --quiet %DUMP_PATH%
if %errorlevel% neq 0 (
    git commit -m "Auto-sync: Updated database snapshot"
    git push origin project
    echo [SUCCESS] Database dump committed and pushed.
) else (
    echo [INFO] No changes in DB dump.
)

pause
