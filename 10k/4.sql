--Поиск 3 самых прибыльных фильмов за неделю
EXPLAIN ANALYSE
SELECT m.name,
       sum(t.price) AS total_price
FROM tickets AS t
         LEFT JOIN showtime AS s ON t.showtime_id = s.id
         LEFT JOIN movies AS m ON s.movie_id = m.id
WHERE (s.start_time BETWEEN (CURRENT_DATE - INTERVAL '7 day') AND CURRENT_DATE)
  AND t.price IS NOT NULL
GROUP BY m.name
ORDER BY total_price DESC LIMIT 3;
-- Limit  (cost=290.84..290.84 rows=3 width=548) (actual time=2.589..2.591 rows=3 loops=1)
-- Planning Time: 2.038 ms
-- Execution Time: 2.701 ms

create index idx_sessions_datetime on showtime (start_time);
-- Limit  (cost=270.85..270.86 rows=3 width=59) (actual time=6.711..6.723 rows=3 loops=1)
-- Planning Time: 1.005 ms
-- Execution Time: 7.117 ms

-- Запрос после создания индекса
EXPLAIN ANALYSE
SELECT m.name,
       sum(t.price) AS total_price
FROM tickets AS t
         LEFT JOIN showtime AS s ON t.showtime_id = s.id
         LEFT JOIN movies AS m ON s.movie_id = m.id
WHERE (s.start_time BETWEEN (CURRENT_DATE - INTERVAL '7 day') AND CURRENT_DATE)
  AND t.price IS NOT NULL
GROUP BY m.name
ORDER BY total_price DESC LIMIT 3;
-- Limit  (cost=290.84..290.84 rows=3 width=548) (actual time=1.116..1.201 rows=3 loops=1)
-- Planning Time: 1.014 ms
-- Execution Time: 0.530 ms

-- Вывод: Индексы значительно повлияли на производительность запроса