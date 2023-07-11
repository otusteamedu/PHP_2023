# PHP_2023_HW_10

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

# Запуск
1. `docker-compose build`
1. `docker-compose up`

# SQL
1. `docker/postrgesql-initdb.d` - запускаются при создании БД
   1. `10-create-table.sql` - создание таблиц
   1. `90-insert-hall.sql` - заполнение залов
   1. `91-insert-movie.sql` - заполнение фильмов
   1. `92-insert-seat.sql` - заполнение посадочных мест для залов
   1. `93-insert-sessions.sql` - заполнение сеансов
   1. `94-insert-ticket.sql` - заполнение билетов для сеансов
1. `sql`
   1. `select.sql` - нахождения самого прибыльного фильма