--Подсчёт проданных билетов за неделю
EXPLAIN
ANALYSE
SELECT count(tickets.id)
FROM tickets
         LEFT JOIN showtime ON tickets.showtime_id = showtime.id
WHERE showtime.start_time BETWEEN date_trunc('week', now())
          AND (date_trunc('week', now()) + '6 days 23 hours 59 minutes'::interval);
-- Aggregate  (cost=227.26..227.27 rows=1 width=8) (actual time=3.010..3.012 rows=1 loops=1)
-- Planning Time: 0.297 ms
-- Execution Time: 3.158 ms

create index idx_datetime on showtime (start_time);
-- Aggregate  (cost=198.26..198.27 rows=1 width=8) (actual time=1.527..1.530 rows=1 loops=1)
-- Planning Time: 2.306 ms
-- Execution Time: 1.578 ms

-- Запрос после создания индекса
EXPLAIN
ANALYSE
SELECT count(tickets.id)
FROM tickets
         LEFT JOIN showtime ON tickets.showtime_id = showtime.id
WHERE showtime.start_time BETWEEN date_trunc('week', now())
          AND (date_trunc('week', now()) + '6 days 23 hours 59 minutes'::interval);
-- Aggregate  (cost=227.26..227.27 rows=1 width=8) (actual time=1.009..1.010 rows=1 loops=1)
-- Planning Time: 0.056 ms
-- Execution Time: 1.070 ms

-- Вывод: Индексы значительно повлияли на производительность запроса