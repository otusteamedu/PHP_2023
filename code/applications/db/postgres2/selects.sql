#№3 Формирование афиши (фильмы, которые показывают сегодня)
SELECT movies.name, date FROM sessions
LEFT JOIN movies ON movie_id = movies.id
WHERE date >= '2023-09-18 00:00:00'::timestamp AND date <= '2023-09-18 23:59:59'::timestamp;
#name |             date
#------+------------------------------
# my1  | 2023-09-18 20:04:20.37681+00
# my2  | 2023-09-18 20:04:20.37681+00
# my2  | 2023-09-18 20:04:20.37681+00
# my2  | 2023-09-18 20:04:20.37681+00
# my2  | 2023-09-18 20:04:20.37681+00
# my3  | 2023-09-18 20:04:20.37681+00
# my3  | 2023-09-18 20:04:20.37681+00
#(7 rows)

#№1 Выбор всех фильмов на сегодня. Пусть сегодня 18ое число.
SELECT DISTINCT movies.name FROM sessions
LEFT JOIN movies ON movie_id = movies.id
WHERE date >= '2023-09-18 00:00:00'::timestamp AND date <= '2023-09-18 23:59:59'::timestamp;
#name
#------
# my1
# my2
# my3
#(3 rows)

#№2 Подсчёт проданных билетов за неделю
SELECT COUNT(*) FROM sessions
RIGHT JOIN tickets ON sessions.id = tickets.movie_session_id
WHERE date >= now() - interval '7 days' AND sold;
#count
#-------
#   180
#(1 row)

#№4 Поиск 3 самых прибыльных фильмов за неделю
SELECT movies.name, sum(price) as "касса за неделю" FROM sessions
LEFT JOIN movies ON movie_id = movies.id
RIGHT JOIN tickets ON sessions.id = tickets.movie_session_id
WHERE date >= now() - interval '7 days' AND sold
GROUP BY movies.name
ORDER BY "касса за неделю" DESC LIMIT 3;
#name | касса за неделю
#------+-----------------
# my1  |        14530.00
# my   |        13393.00
#(2 rows)

#№5 Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
SELECT seat_number, case when sold then 'занято' else 'свободно' end as статус
FROM tickets JOIN seats on seats.id = tickets.seat_id WHERE movie_session_id = 1;
#seat_number |  статус
#-------------+----------
#           1 | свободно
#           2 | занято
#           3 | свободно
#           4 | занято
#           5 | свободно
#           6 | занято
#...

#№6 Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс
SELECT concat(min(price), '-', max(price)) as "диапазон цен"
FROM sessions LEFT JOIN tickets on tickets.movie_session_id = sessions.id WHERE tickets.movie_session_id = 1;
#диапазон цен
#--------------
# 57.00-90.00
# (1 row)

##Далее идём по заданию на анализ. посмотрим что даст explain запроса на 18 строк:
EXPLAIN(SELECT movies.name, date FROM sessions LEFT JOIN movies ON movie_id = movies.id);
#QUERY PLAN
#-----------------------------------------------------------------------
# Hash Left Join  (cost=13.15..44.70 rows=1700 width=524)
#   Hash Cond: (sessions.movie_id = movies.id)
#   ->  Seq Scan on sessions  (cost=0.00..27.00 rows=1700 width=12)
#   ->  Hash  (cost=11.40..11.40 rows=140 width=520)
#         ->  Seq Scan on movies  (cost=0.00..11.40 rows=140 width=520)
#(5 rows)


###заполню таблицу sessions данными на 10 000 строк
INSERT INTO sessions (id, date, hall_id, movie_id) VALUES
(generate_series(19, 100019), now() - interval '2 days', 1, floor(random()* (5-2 + 1) + 2));

###посмотрим план запроса на 10 000 строк
EXPLAIN(SELECT movies.name, date FROM sessions LEFT JOIN movies ON movie_id = movies.id);
#QUERY PLAN
#-----------------------------------------------------------------------
# Hash Left Join  (cost=13.15..2026.49 rows=108460 width=524)
#   Hash Cond: (sessions.movie_id = movies.id)
#   ->  Seq Scan on sessions  (cost=0.00..1722.60 rows=108460 width=12)
#   ->  Hash  (cost=11.40..11.40 rows=140 width=520)
#         ->  Seq Scan on movies  (cost=0.00..11.40 rows=140 width=520)
#(5 rows)

#Все запросы отрабатывают достаточно быстро и достаточно одинаково стоят. А что если добавить условие WHERE
EXPLAIN(SELECT movies.name, date FROM sessions LEFT JOIN movies ON movie_id = movies.id
WHERE date >= '2023-09-18 00:00:00'::timestamp AND date <= '2023-09-18 23:59:59'::timestamp)
#    Nested Loop Left Join  (cost=0.00..2162.63 rows=6 width=524)
#    Join Filter: (sessions.movie_id = movies.id)
#    ->  Seq Scan on sessions  (cost=0.00..2138.28 rows=6 width=12)
#    Filter: ((date >= '2023-09-18 00:00:00'::timestamp without time zone) AND (date <= '2023-09-18 23:59:59'::timestamp without time zone))
#    ->  Materialize  (cost=0.00..12.10 rows=140 width=520)
#    ->  Seq Scan on movies  (cost=0.00..11.40 rows=140 width=520)
#    (6 rows)

## теперь добавим индекс на поле, по которому задаётся условие where
CREATE INDEX sessions_date ON sessions (date);
##вот как изменился explain. Cost значительно уменьшился
#    Hash Right Join  (cost=8.46..21.13 rows=5 width=524)
#    Hash Cond: (movies.id = sessions.movie_id)
#    ->  Seq Scan on movies  (cost=0.00..11.40 rows=140 width=520)
#    ->  Hash  (cost=8.39..8.39 rows=5 width=12)
#    ->  Index Scan using sessions_date on sessions  (cost=0.29..8.39 rows=5 width=12)
#    Index Cond: ((date >= '2023-09-18 00:00:00'::timestamp without time zone) AND (date <= '2023-09-18 23:59:59'::timestamp without time zone))
#    (6 rows)


###отсортированный список (15 значений) самых больших по размеру объектов БД (таблицы, включая индексы, сами индексы)
SELECT nspname || '.' || relname as name,
pg_size_pretty(pg_total_relation_size(C.oid)) as totalsize,
pg_size_pretty(pg_relation_size(C.oid)) as relsize
FROM pg_class C
LEFT JOIN pg_namespace N ON (N.oid = C.relnamespace) WHERE nspname NOT IN ('pg_catalog', 'information_schema')
ORDER BY pg_total_relation_size(C.oid) DESC LIMIT 15;
#             name              | totalsize |  relsize
#-------------------------------+-----------+------------
# public.sessions               | 8040 kB   | 5104 kB
# public.sessions_pkey          | 2208 kB   | 2208 kB
# public.sessions_date          | 696 kB    | 696 kB
# pg_toast.pg_toast_2618        | 560 kB    | 512 kB
# public.tickets                | 96 kB     | 40 kB
# pg_toast.pg_toast_2619        | 72 kB     | 24 kB
# public.seats                  | 56 kB     | 16 kB
# pg_toast.pg_toast_1255        | 56 kB     | 8192 bytes
# public.movies                 | 32 kB     | 8192 bytes
# public.tickets_pkey           | 32 kB     | 32 kB
# public.moviesAttributesValues | 32 kB     | 8192 bytes
# public.moviesAttributesTypes  | 24 kB     | 8192 bytes
# public.theater                | 24 kB     | 8192 bytes
# public.moviesAttributes       | 24 kB     | 8192 bytes
# public.halls                  | 24 kB     | 8192 bytes
# (15 rows)

###отсортированные списки (5 значений) самых часто используемых индексов
select * from pg_stat_user_indexes ORDER BY idx_scan DESC LIMIT 5;
#relid | indexrelid | schemaname |   relname    |          indexrelname           | idx_scan | idx_tup_read | idx_tup_fetch
#-------+------------+------------+--------------+---------------------------------+----------+--------------+---------------
# 16434 |      16440 | public     | movies   | movies_pkey   |   100001 |       100001 |        100001
# 16410 |      16414 | public     | halls    | halls_pkey    |   100001 |       100001 |        100001
# 16443 |      16447 | public     | sessions | sessions_pkey |      695 |          695 |           695
# 16422 |      16426 | public     | seats    | seats_pkey    |       32 |           32 |            32
# 16443 |      16634 | public     | sessions | sessions_date |        2 |            2 |             0
#(5 rows)

###отсортированные списки (5 значений) самых редко используемых индексов
select * from pg_stat_user_indexes ORDER BY idx_scan LIMIT 5;
#relid | indexrelid | schemaname |        relname         |        indexrelname         | idx_scan | idx_tup_read | idx_tup_fetch
#-------+------------+------------+------------------------+-----------------------------+----------+--------------+---------------
# 16548 |      16552 | public     | moviesAttributes       | moviesAttributes_pkey       |        0 |            0 |             0
# 16541 |      16545 | public     | moviesAttributesTypes  | moviesAttributesTypes_pkey  |        0 |            0 |             0
# 16390 |      16394 | public     | theater                | theater_pkey                |        0 |            0 |             0
# 16617 |      16622 | public     | tickets                | tickets_pkey                |        0 |            0 |             0
# 16598 |      16604 | public     | moviesAttributesValues | moviesAttributesValues_pkey |        0 |            0 |             0
