up: docker-up
build: up-build
stop: docker-stop
down: down
ps: docker-ps
777: over-permission
sh: exec

docker-up:
	docker-compose up -d

exec:
	docker-compose exec fpm_service_otus sh

up-build:
	docker-compose up --build -d

docker-ps:
	docker-compose ps

over-permission:
	sudo chmod -R 0777 ./

docker-stop:
	docker-compose stop

down:
	docker-compose down