up: start docker-up
reload: re
stop: docker-stop
ps: docker-ps
sh: fpm-sh
777: over-permission

docker-up:
	docker-compose up --build -d

docker-ps:
	docker-compose ps

fpm-sh:
	docker-compose exec fpm_service sh

over-permission:
	sudo chmod -R 0777 ./

docker-stop:
	docker-compose stop

re:
	docker-compose stop
	docker-compose up --build -d



start:
	-i docker network create 172.31.0.0 --subnet 172.31.0.0/16
