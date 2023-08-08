help:
	@echo 'Please use command `make setup`, `make run-calc`, `make run-sort` and others'

setup:
	docker-compose up -d --build
	docker exec hw-02-nick-bash-bc make setup

run-calc:
	docker exec hw-02-nick-bash-bc make run-calc

run-calc-error-case-01:
	docker exec hw-02-nick-bash-bc make run-calc-error-case-01

run-calc-error-case-02:
	docker exec hw-02-nick-bash-bc make run-calc-error-case-02

run-calc-error-case-03:
	docker exec hw-02-nick-bash-bc make run-calc-error-case-03

run-calc-error-case-04:
	docker exec hw-02-nick-bash-bc make run-calc-error-case-04

run-sort:
	docker exec hw-02-nick-bash-bc make run-sort

dc-up-b:
	docker-compose up --build

dc-up:
	docker-compose up

dc-up-d:
	docker-compose up -d

dc-down:
	docker-compose down

dc-stop:
	docker-compose stop
