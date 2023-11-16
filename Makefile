# Linux установка "sudo apt install make"
# Example use "make first-start"

# Первый запуск
first-start: build up

# Разборка сборка полностью
init: down build pull up

# Остановить запустить
restart: stop start

# Частичная разборка сборка
restart-up: down up

start:
	docker-compose start

stop:
	docker-compose stop

up:
	docker-compose up -d

pull:
	docker-compose pull

build:
	docker-compose build

down:
	docker-compose down --remove-orphans
