--Формирование афиши (фильмы, которые показывают сегодня)
EXPLAIN
ANALYSE
SELECT m.name       as "Film name",
       s.start_time as "Datetime",
       h.name       as "Hall name"
FROM showtime as s
         LEFT JOIN movies m ON s.movie_id = m.id
         LEFT JOIN halls h ON s.hall_id = h.id
WHERE s.start_time BETWEEN (concat(CURRENT_DATE, ' 00:00:00'))::timestamp
  AND (concat(CURRENT_DATE, ' 23:59:59'))::timestamp;
-- Hash Left Join  (cost=13.43..132.00 rows=7 width=1040) (actual time=0.103..0.196 rows=1 loops=1)
-- Planning Time: 3.183 ms
-- Execution Time: 0.313 ms

create index idx_sessions_datetime on showtime (start_time);
-- Hash Right Join  (cost=5.23..17.35 rows=2 width=551) (actual time=0.223..0.230 rows=1 loops=1)
-- Planning Time: 2.990 ms
-- Execution Time: 0.292 ms

-- Запрос после создания индекса
EXPLAIN
ANALYSE
SELECT m.name       as "Film name",
       s.start_time as "Datetime",
       h.name       as "Hall name"
FROM showtime as s
         LEFT JOIN movies m ON s.movie_id = m.id
         LEFT JOIN halls h ON s.hall_id = h.id
WHERE s.start_time BETWEEN (concat(CURRENT_DATE, ' 00:00:00'))::timestamp
  AND (concat(CURRENT_DATE, ' 23:59:59'))::timestamp;
-- Hash Left Join  (cost=13.43..132.00 rows=7 width=1040) (actual time=0.096..0.106 rows=1 loops=1)
-- Planning Time: 0.885 ms
-- Execution Time: 0.064 ms

-- Вывод: Индексы значительно повлияли на производительность запроса