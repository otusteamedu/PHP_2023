.SILENT:
.DEFAULT: install

install:
	composer install --ignore-platform-reqs

analyse:
	vendor/bin/phpinsights analyse -n

fix:
	vendor/bin/phpinsights analyse -n --fix

format:
	vendor/bin/phpcs && vendor/bin/phpcbf

start:
	docker compose up
