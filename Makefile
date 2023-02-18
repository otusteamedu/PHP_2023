.SILENT:
.DEFAULT_GOAL: install

install:
	composer install --ignore-platform-reqs

format:
	vendor/bin/phpcs && vendor/bin/phpcbf

start:
	php public/index.php
