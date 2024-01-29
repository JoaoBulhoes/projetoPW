php artisan migrate:fresh --seed --env=testing
cls
php artisan test --filter=DocumentApiTest --env=testing
pause
exit