--Выбор фильмов на сегодня
EXPLAIN
ANALYSE
SELECT DISTINCT movies.name
FROM showtime
         LEFT JOIN movies ON movies.id = showtime.movie_id
WHERE showtime.start_time BETWEEN current_date AND concat(CURRENT_DATE, ' 23:59:59')::timestamp;
-- Unique  (cost=108.05..108.09 rows=7 width=516) (actual time=0.096..0.097 rows=1 loops=1)
-- Planning Time: 2.946 ms
-- Execution Time: 0.132 ms

create index idx_datetime on showtime (start_time);
-- Unique  (cost=12.07..12.08 rows=1 width=516) (actual time=0.080..0.082 rows=1 loops=1)
-- Planning Time: 1.595 ms
-- Execution Time: 0.134 ms

-- Запрос после создания индекса
EXPLAIN
ANALYSE
SELECT DISTINCT movies.name
FROM showtime
         LEFT JOIN movies ON movies.id = showtime.movie_id
WHERE showtime.start_time BETWEEN current_date AND concat(CURRENT_DATE, ' 23:59:59')::timestamp;
-- Unique  (cost=108.05..108.09 rows=7 width=516) (actual time=0.030..0.031 rows=1 loops=1)
-- Planning Time: 1.436 ms
-- Execution Time: 0.027 ms

-- Вывод: Индексы значительно повлияли на производительность запроса