up:
	docker-compose up -d --build --force-recreate
down:
	docker-compose down

composer-install:
	docker run --rm -it -v ${PWD}:/app composer/composer:2.3.9 install