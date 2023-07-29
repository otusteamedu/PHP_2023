-- 3. Формирование афиши (фильмы, которые показывают сегодня)
explain
select f.name as film, s.date as time, h.name as hall, h.class as class
from session s
         inner join film f on f.id = s.film_id
         inner join hall h on h.id = s.hall_id
where date = current_date;

-- 10_000
-- Nested Loop  (cost=0.43..246.99 rows=2 width=249)
--   ->  Nested Loop  (cost=0.29..230.61 rows=2 width=25)
--         ->  Seq Scan on session s  (cost=0.00..214.00 rows=2 width=12)
--               Filter: (date = CURRENT_DATE)
--         ->  Index Scan using film_pk on film f  (cost=0.29..8.30 rows=1 width=21)
--               Index Cond: (id = s.film_id)
--   ->  Index Scan using hall_pk on hall h  (cost=0.15..8.17 rows=1 width=232)
--         Index Cond: (id = s.hall_id)

-- 10_000_000
-- Gather  (cost=1000.59..131624.10 rows=1236 width=249)
--         Workers Planned: 2
--   ->  Nested Loop  (cost=0.59..130500.50 rows=515 width=249)
--         ->  Nested Loop  (cost=0.43..130485.42 rows=515 width=25)
--               ->  Parallel Seq Scan on session s  (cost=0.00..126195.72 rows=515 width=12)
--                     Filter: (date = CURRENT_DATE)
--               ->  Index Scan using film_pk on film f  (cost=0.43..8.33 rows=1 width=21)
--                     Index Cond: (id = s.film_id)
--         ->  Memoize  (cost=0.16..0.21 rows=1 width=232)
--               Cache Key: s.hall_id
--               Cache Mode: logical
--               ->  Index Scan using hall_pk on hall h  (cost=0.15..0.20 rows=1 width=232)
--                     Index Cond: (id = s.hall_id)

-- Index for date column in session table
create index idx_session_date on session(date);

-- Bitmap Index Scan instead parallel seq scan after index creation
-- Nested Loop  (cost=1018.61..11631.51 rows=1236 width=249)
--   ->  Gather  (cost=1018.45..11598.43 rows=1236 width=25)
--         Workers Planned: 1
--         ->  Nested Loop  (cost=18.45..10474.83 rows=727 width=25)
--               ->  Parallel Bitmap Heap Scan on session s  (cost=18.02..4419.27 rows=727 width=12)
--                     Recheck Cond: (date = CURRENT_DATE)
--                     ->  Bitmap Index Scan on idx_session_date  (cost=0.00..17.71 rows=1236 width=0)
--                           Index Cond: (date = CURRENT_DATE)
--               ->  Index Scan using film_pk on film f  (cost=0.43..8.33 rows=1 width=21)
--                     Index Cond: (id = s.film_id)
--   ->  Memoize  (cost=0.16..0.21 rows=1 width=232)
--         Cache Key: s.hall_id
--         Cache Mode: logical
--         ->  Index Scan using hall_pk on hall h  (cost=0.15..0.20 rows=1 width=232)
--               Index Cond: (id = s.hall_id)