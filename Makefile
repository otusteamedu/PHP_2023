init: docker-down-clear docker-build docker-up composer-install
down: docker-down-clear
test: composer-test
remove-build-cache: docker-remove-build-cache

docker-up:
	docker compose up -d

docker-down-clear:
	docker compose down -v --remove-orphans

docker-build:
	docker compose build

docker-remove-build-cache:
	docker buildx prune -f

composer-install:
	docker compose run --rm php-cli composer install

composer-update:
	docker compose run --rm php-cli composer update

composer-test:
	docker compose run --rm php-cli composer test
