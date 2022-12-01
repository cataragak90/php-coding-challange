start:
	docker-compose build
	docker-compose run php composer install
	docker-compose up -d

stop:
	docker-compose down

php:
	docker-compose exec php bash

logs:
	docker-compose logs -f php

run-tests:
	docker-compose -f ./docker-compose.yml exec php php /www/vendor/phpunit/phpunit/phpunit