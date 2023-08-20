#!/usr/bin/make
SHELL = /bin/bash

include .env

init:
	cp .env.sample .env && cp app/.env.sample app/.env &&  make tls && make build && make up && make index-elastic
tls:
	mkcert -cert-file .docker/traefik/certs/local-cert.pem -key-file .docker/traefik/certs/local-key.pem "otus-redis.localhost" "*.otus-redis.localhost" && mkcert -install
build:
	docker compose build
up:
	docker compose up -d
down:
	docker-compose down
build-php:
	 docker build --build-arg UID=$(id -u) --build-arg GID=$(id -g) -f .docker/php/Dockerfile .
lint:
	 docker run --rm -i hadolint/hadolint < .docker/php/Dockerfile
check-elastic:
	curl --fail http://localhost:9200 -u ${ELASTIC_USER}:${ELASTIC_PASSWORD}
index-elastic:
	curl \
    	--location \
        --request PUT 'http://localhost:9200/${ELASTIC_INDEX}' \
        --header 'Content-Type: application/json' \
        --data-binary "@elastic/mapping.json" \
        -u ${ELASTIC_USER}:${ELASTIC_PASSWORD}