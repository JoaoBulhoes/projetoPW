php artisan migrate:fresh --seed --env=testing
cls
php artisan test --filter=DocumentApiTest --env=testing
php artisan test --filter=UserApiTest --env=testing
pause
exit