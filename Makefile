start:
	php artisan serve --host=0.0.0.0 --port=8000
log:
	tail -f storage/logs/laravel.log
clear-cache:
	php artisan cache:clear
	php artisan route:clear
	php artisan config:clear
	php artisan view:clear
rollback:
	php artisan migrate:rollback
set-env:
	cp -n .env.example .env || true
setup:
	set-env
	php artisan key:generate
	php artisan migrate
	php artisan db:seed
