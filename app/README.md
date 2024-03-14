# Homework 11

1. `cp .env.example .env`
2. `docker-compose up --build -d`
3. `docker compose exec -it php bash`
4. `cd /var/www/application.local`
5. `composer install`

Примеры команд:

`php public/index.php --title="рыцори" --category="Исторический роман" --price="lte 2000"`

`php public/index.php --category="Исторический роман" --price="gte 9000"`
