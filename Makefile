#!/usr/bin/make
SHELL = /bin/bash

include .env

init:
	cp .env.sample .env && cp app/.env.sample app/.env && make build && make up
build:
	docker compose build
up:
	docker compose up -d
down:
	docker-compose down --remove-orphans
php:
	docker-compose exec php bash
