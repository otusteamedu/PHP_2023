# How to run this:
1. Clone this repo
2. Run `cp .env.example .env`
3. Run `docker-compose up -d`
4. Run `docker-compose exec -it app bash -c 'composer install --ignore-platform-reqs'`

# This local dev environment includes:

1. Docker and docker compose
2. PHP-FPM 7.2
3. Nginx Web Server (Host http://application.local)
4. PostgresSQL
5. Memcached
6. Redis
