@echo off
start "PHP Server" cmd /k "php artisan serve"
start "Vite/NPM Dev" cmd /k "npm run dev"