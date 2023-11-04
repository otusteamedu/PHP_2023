# PHP_2023

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

## Локальное развёртывание проекта
### 1. Установить docker 
desktop (для mac) 
docker engine + docker-compose (для linux)
### 2. Клонировать репозиторий
git clone https://github.com/otusteamedu/PHP_2023/tree/BSalenko/main.git
### 3. Настроить `.env` файл
Run `cp .env.example .env`
### 4. Docker
Run 'docker-compose up --build -d'
### 5. Установка зависимостей
Run `docker-compose exec app composer install`
### 6. Проверить
В случае успешного выполнения всего вышеперечисленного - заходим на http://application.local

Если не открывается, то прописать в хосты /etc/hosts на mac/linux, c:\windows\system32\drivers\etc\hosts на винде

## Техническая информация

| Package    | Version         |
|------------|-----------------|
| nginx      | latest          |
| PHP        | 8.2             |
| memcached  | memcached-3.2.0 |
| redis      | latest          |
| PostgreSQL | 14              |