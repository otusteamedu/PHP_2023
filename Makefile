up: docker-up
build: build
stop: docker-stop
down: down
ps: docker-ps
777: over-permission

docker-up:
	docker-compose up -d

build:
	docker-compose up --build -d

docker-ps:
	docker-compose ps

over-permission:
	sudo chmod -R 0777 ./

docker-stop:
	docker-compose stop

down:
	docker-compose down