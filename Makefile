up: docker-up
stop: docker-stop
ps: docker-ps
777: over-permission

docker-up:
	docker-compose up -d

docker-ps:
	docker-compose ps

over-permission:
	sudo chmod -R 0777 ./

docker-stop:
	docker-compose stop
