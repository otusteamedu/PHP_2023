.SILENT:

default: start

install:
	composer install --ignore-platform-reqs
	docker compose build

start:
	docker compose up -d
	php public/index.php

stop:
	docker compose stop

format:
	vendor/bin/phpcbf
