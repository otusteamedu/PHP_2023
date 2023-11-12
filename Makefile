DOCKER_COMPOSE = docker-compose -f ./docker/docker-compose.yml
DOCKER_COMPOSE_PHP_FPM_EXEC = ${DOCKER_COMPOSE} exec -u www-data php-fpm

build:
	${DOCKER_COMPOSE} build

up:
	${DOCKER_COMPOSE} up -d --remove-orphans
down:
	${DOCKER_COMPOSE} down
restart:
	${DOCKER_COMPOSE} down && ${DOCKER_COMPOSE} up -d --remove-orphans
exec:
	${DOCKER_COMPOSE} exec -u www-data php-fpm bash
