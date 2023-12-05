init: docker-down-clear docker-build docker-up
down: docker-down-clear
remove-build-cache: docker-remove-build-cache

docker-up:
	docker compose up -d

docker-down-clear:
	docker compose down -v --remove-orphans

docker-build:
	docker compose build

docker-remove-build-cache:
	docker buildx prune -f

docker-city-sort:
	docker compose run --rm app ./city-sort.sh

docker-city-sum-example:
	docker compose run --rm app sh ./sum.sh -4 5

docker-city-sum-bc-example:
	docker compose run --rm app sh ./sum-bc.sh -4.2 5
