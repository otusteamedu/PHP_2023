##################
# Variables
##################

DOCKER_COMPOSE = docker-compose -f ./app/docker/docker-compose.yml
DOCKER_COMPOSE_PHP_FPM_EXEC = ${DOCKER_COMPOSE} exec -u www-data php-fpm

##################
# Docker compose
##################

build:
	${DOCKER_COMPOSE} build

start:
	${DOCKER_COMPOSE} start

stop:
	${DOCKER_COMPOSE} stop

up:
	${DOCKER_COMPOSE} up -d --remove-orphans

down:
	${DOCKER_COMPOSE} down

restart:
	${DOCKER_COMPOSE} up -d --build --force-recreate --remove-orphans

dc_ps:
	${DOCKER_COMPOSE} ps

dc_logs:
	${DOCKER_COMPOSE} logs -f

##################
# App
##################

app_bash:
	${DOCKER_COMPOSE} exec -u www-data php-fpm bash
test:
	${DOCKER_COMPOSE} exec -u www-data php-fpm bin/phpunit
cache:
	docker-compose -f ./app/docker/docker-compose.yml exec -u www-data php-fpm bin/console cache:clear
	docker-compose -f ./app/docker/docker-compose.yml exec -u www-data php-fpm bin/console cache:clear --env=test