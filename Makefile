up: build install-dependencies consumer-start

build:
	docker-compose up -d

consumer-start:
	docker exec otus_php bin/console statement:generate

install-dependencies:
	docker exec otus_php composer install --no-cache --no-ansi
