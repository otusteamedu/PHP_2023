.SILENT:
.DEFAULT_GOAL: install

install:
	composer install --ignore-platform-reqs
	docker compose build

start:
	docker compose up -d

stop:
	docker compose stop

format:
	vendor/bin/phpcs && vendor/bin/phpcbf

test:
	XDEBUG_MODE=coverage vendor/bin/phpunit --testdox --no-progress

coverage:
	XDEBUG_MODE=coverage vendor/bin/phpunit --coverage-text
