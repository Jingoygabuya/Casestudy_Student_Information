@echo off
echo Starting Ionic Development Server...
echo.
set PATH=C:\Program Files\nodejs;%PATH%
cd /d "%~dp0"
call ionic serve

