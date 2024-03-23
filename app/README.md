# Homework 13

1. `cd app`
2. `cp .env.example .env`
3. `docker-compose up --build -d`
4. `docker-compose exec -it postrges bash`
5. `psql -U test test < /var/www/application.local/sql/ddl.sql`
6. `psql -U test test < /var/www/application.local/sql/dml.sql`
7. `docker-compose exec -it php bash`
8. `cd /var/www/application.local`
9. `composer install`
10. `php public/index.php`