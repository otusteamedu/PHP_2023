-- 1. Выбор всех фильмов на сегодня
explain
select distinct f.name
from session s
         inner join film f on f.id = s.film_id
where date = current_date;

-- 10_000
-- Unique  (cost=230.62..230.63 rows=2 width=17)
--         ->  Sort  (cost=230.62..230.62 rows=2 width=17)
--         Sort Key: f.name
--         ->  Nested Loop  (cost=0.29..230.61 rows=2 width=17)
--               ->  Seq Scan on session s  (cost=0.00..214.00 rows=2 width=4)
--                     Filter: (date = CURRENT_DATE)
--               ->  Index Scan using film_pk on film f  (cost=0.29..8.30 rows=1 width=21)
--                     Index Cond: (id = s.film_id)

-- 10_000_000
-- Unique  (cost=131508.64..131655.69 rows=1236 width=17)
--         ->  Gather Merge  (cost=131508.64..131652.60 rows=1236 width=17)
--         Workers Planned: 2
--         ->  Sort  (cost=130508.62..130509.91 rows=515 width=17)
--               Sort Key: f.name
--               ->  Nested Loop  (cost=0.43..130485.42 rows=515 width=17)
--                     ->  Parallel Seq Scan on session s  (cost=0.00..126195.72 rows=515 width=4)
--                           Filter: (date = CURRENT_DATE)
--                     ->  Index Scan using film_pk on film f  (cost=0.43..8.33 rows=1 width=21)
--                           Index Cond: (id = s.film_id)

-- Index for date column in session table
create index idx_session_date on session(date);

-- Bitmap Index Scan instead parallel seq scan after index creation
-- Unique  (cost=11509.40..11653.36 rows=1236 width=17)
--         ->  Gather Merge  (cost=11509.40..11650.27 rows=1236 width=17)
--         Workers Planned: 1
--         ->  Sort  (cost=10509.39..10511.21 rows=727 width=17)
--               Sort Key: f.name
--               ->  Nested Loop  (cost=18.45..10474.83 rows=727 width=17)
--                     ->  Parallel Bitmap Heap Scan on session s  (cost=18.02..4419.27 rows=727 width=4)
--                           Recheck Cond: (date = CURRENT_DATE)
--                           ->  Bitmap Index Scan on idx_session_date  (cost=0.00..17.71 rows=1236 width=0)
--                                 Index Cond: (date = CURRENT_DATE)
--                     ->  Index Scan using film_pk on film f  (cost=0.43..8.33 rows=1 width=21)
--                           Index Cond: (id = s.film_id)