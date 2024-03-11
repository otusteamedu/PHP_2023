# Homework 12

1. `cd app`
2. `cp .env.example .env`
3. `docker-compose up --build -d`
4. `docker-compose exec -it php bash`
5. `cd application.local`
6. `composer install`
 
## Команды для работы

### Добавление событий

`php public/index.php add --priority=1000 --event="event:1" --param1=1 --param2=1`

`php public/index.php add --priority=2000 --event="event:2" --param1=2 --param2=2`

`php public/index.php add --priority=3000 --event="event:3" --param1=1 --param2=2`

### Поиск по параметрам

`php public/index.php get --param1=1 --param2=2`

`php public/index.php get --param1=2`

### Вывести все

`php public/index.php all`

### Очистить базу

`php public/index.php clear`