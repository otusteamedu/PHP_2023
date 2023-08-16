# PHP_2023_HW_13

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

## Запуск
1. `docker-compose build`
1. `docker-compose up`
1. Заполнение базы занимает большое время. Для уменьшения числа записей необходимо изменить следующие параметры:
   1. `docker/postrgesql-initdb.d/70-insert-hall.sql`:  
      `set my.cnt_hall = 1000;` - количество залов
   2. `docker/postrgesql-initdb.d/73-insert-sessions.sql`:  
      `set my.date_start = '2023-08-01';` - дата начала сеансов  
      `set my.date_end = '2023-09-01';` - дата окончания сеансов

## SQL
1. `docker/postrgesql-initdb.d` - запускаются при создании БД
   1. `10-create-table.sql` - создание таблиц
   1. `11-create-table.sql` - создание таблиц атрибутов
   1. `70-insert-hall.sql` - заполнение залов
   1. `71-insert-movie.sql` - заполнение фильмов
   1. `71-insert-seat-type.sql` - заполнение типов мест
   1. `72-insert-seat.sql` - заполнение посадочных мест для залов
   1. `73-insert-sessions.sql` - заполнение сеансов
   1. `74-insert-price-catalog.sql` - заполнение справочника цен (привязка к сеансу и типу места)
   1. `76-insert-ticket.sql` - заполнение билетов для сеансов
   1. `77-insert-movie-attributes.sql` - заполнение атрибутов 
   1. `78-insert-movies-attributes-value.sql` - заполнение значений атрибутов
   1. `80-create_view_marketing.sql` - создание view маркетинга
   1. `81-create_view_service.sql` - создание view служебных дат

## VIEW
1. `SELECT * FROM public.marketing;` - view маркетинга
1. `SELECT * FROM public.service;` - view служебных дат

## Запросы `sql/`
1. `01/select-all-movie-today.sql` - Выбор всех фильмов на сегодня
1. `02/select-ticket-week.sql` - Подсчёт проданных билетов за неделю
1. `03/select-poster.sql` - Формирование афиши (фильмы, которые показывают сегодня)
1. `04/select-most-profit-movie.sql` - Поиск 3 самых прибыльных фильмов за неделю
1. `05/select-hall-scheme.sql` - Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
1. `06/select-session-price-minmax.sql` - Вывести диапазон минимальной и максимальной цены за билет на конкретный сеанс

## Результаты выполнения запросов
`sql/*/descr.md`
`sql/*/note-*.md`

## Отсортированный список (15 значений) самых больших по размеру объектов БД
```sql
select
	nspname || '.' || relname AS "relation",
	pg_size_pretty(pg_total_relation_size(C.oid)) AS "total_size"
FROM pg_class C
LEFT JOIN pg_namespace N ON (N.oid = C.relnamespace)
ORDER BY pg_total_relation_size(C.oid) desc
LIMIT 15
```
Результат:
```
relation                     |total_size|
-----------------------------+----------+
public.session               |1860 MB   |
public.ticket                |1570 MB   |
public.movie                 |1505 MB   |
public.seat                  |1478 MB   |
public.hall                  |1035 MB   |
public.session_pk            |486 MB    |
public.ticket_pk             |391 MB    |
public.movie_pk              |387 MB    |
public.seat_pk               |383 MB    |
public.hall_pkey             |383 MB    |
public.ticket_session_id_idx |301 MB    |
public.seat_hall_id_idx      |301 MB    |
public.session_start_time_idx|214 MB    |
public.seat_row_idx          |67 MB     |
public.ticket_status_idx     |67 MB     |
```

## Отсортированные списки (по 5 значений) самых часто и редко используемых индексов
```sql
SELECT indexrelname, idx_scan FROM pg_stat_user_indexes order by idx_scan desc limit 5
```
Результат:
```
indexrelname         |idx_scan|
---------------------+--------+
session_pk           | 5004214|
movie_pk             | 1115586|
ticket_session_id_idx|    2353|
seat_pk              |      86|
hall_pkey            |      61|
```

```sql
SELECT indexrelname, idx_scan FROM pg_stat_user_indexes order by idx_scan asc limit 5
```
Результат:
```
indexrelname             |idx_scan|
-------------------------+--------+
attributes_type_pk       |       0|
movie_attributes_pk      |       0|
seat_type_pk             |       0|
ticket_pk                |       0|
movie_attributes_value_pk|       0|
```