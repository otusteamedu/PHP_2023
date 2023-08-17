#!/usr/bin/make
SHELL = /bin/bash

include .env

init:
	cp .env.sample .env && cp app/.env.sample app/.env &&  make tls && docker compose up setup && docker compose build && make up
tls:
	mkcert -cert-file .docker/traefik/certs/local-cert.pem -key-file .docker/traefik/certs/local-key.pem "otus-shop.localhost" "*.otus-shop.localhost" && mkcert -install && docker compose up tls
up:
	docker compose up -d
down:
	docker-compose down
build-php:
	 docker build --build-arg UID=$(id -u) --build-arg GID=$(id -g) -f .docker/php/Dockerfile .
search:
	docker compose exec application sh
lint:
	 docker run --rm -i hadolint/hadolint < .docker/php/Dockerfile
check:
	curl --fail --cacert .docker/elk/tls/certs/ca/ca.crt https://localhost:9200 -u ${ELASTIC_USER}:${ELASTIC_PASSWORD}
index:
	make create-index && make bulk-index
create-index:
	curl \
        --location \
        --cacert .docker/elk/tls/certs/ca/ca.crt \
        --request PUT 'https://localhost:9200/${ELASTIC_INDEX}' \
        --header 'Content-Type: application/json' \
        --data-binary "@elastic/mapping.json" \
        -u ${ELASTIC_USER}:${ELASTIC_PASSWORD}
bulk-index:
	curl \
        --location \
        --cacert .docker/elk/tls/certs/ca/ca.crt \
        --request POST 'https://localhost:9200/_bulk' \
        --header 'Content-Type: application/json' \
        --data-binary "@elastic/books.json" \
        --user ${ELASTIC_USER}:${ELASTIC_PASSWORD}
