start:
		php artisan serve

test:
		php artisan test

lint:
		vendor/bin/phpcs --standard=PSR2 ./app
