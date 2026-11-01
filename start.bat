@echo off
REM Chay PETOPIA: backend (8080) + frontend (8000), roi mo trinh duyet
cd /d C:\PETOPIA
start "PETOPIA backend 8080" D:\xampp\php\php.exe -S localhost:8080 -t backend
start "PETOPIA frontend 8000" D:\xampp\php\php.exe -S localhost:8000 -t frontend frontend/router.php
timeout /t 2 >nul
start http://localhost:8000
