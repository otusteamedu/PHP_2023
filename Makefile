up: build consumer-start

build:
	docker-compose up -d

consumer-start:
	docker exec otus_php bin/console statement:generate
