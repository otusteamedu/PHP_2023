# PHP_2023_HW_12

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

# Запуск
1. `docker-compose build`
1. `docker-compose up`

# SQL
1. `docker/postrgesql-initdb.d` - запускаются при создании БД
   1. `10-create-table.sql` - создание таблиц
   1. `11-create-table.sql` - создание таблиц атрибутов
   1. `70-insert-hall.sql` - заполнение залов
   1. `71-insert-movie.sql` - заполнение фильмов
   1. `71-insert-seat-type.sql` - заполнение типов мест
   1. `72-insert-seat.sql` - заполнение посадочных мест для залов
   1. `73-insert-sessions.sql` - заполнение сеансов
   1. `73-insert-price-catalog.sql` - заполнение справочника цен (привязка к сеансу и типу места)
   1. `74-insert-ticket.sql` - заполнение билетов для сеансов
   1. `75-insert-movie-attributes.sql` - заполнение атрибутов 
   1. `76-insert-movies-attributes-value.sql` - заполнение значений атрибутов
   1. `80-create_view_marketing.sql` - создание view маркетинга
   1. `81-create_view_service.sql` - создание view служебных дат

# VIEW
1. `SELECT * FROM public.marketing;` - view маркетинга
1. `SELECT * FROM public.service;` - view служебных дат
