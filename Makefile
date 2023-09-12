up: build install-dependencies consumer-start

stop:
	docker-compose stop

build:
	docker-compose up -d

install-dependencies:
	docker exec otus_php composer install --no-cache --no-ansi

consumer-start:
	docker exec otus_php bin/console messenger:consume async
