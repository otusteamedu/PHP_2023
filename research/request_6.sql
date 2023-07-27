-- 6. Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс
explain
select max(t.cost) as "Max price", min(t.cost) as "Min price"
from ticket t
         inner join session s on s.id = t.session_id
where session_id = 8;

-- 10_000
-- Aggregate  (cost=187.25..187.26 rows=1 width=8)
--            ->  Nested Loop  (cost=0.29..187.00 rows=51 width=4)
--         ->  Index Only Scan using session_pk on session s  (cost=0.29..4.30 rows=1 width=4)
--               Index Cond: (id = 8)
--         ->  Seq Scan on ticket t  (cost=0.00..182.19 rows=51 width=8)
--               Filter: (session_id = 8)

-- 10_000_000
-- Aggregate  (cost=107142.28..107142.29 rows=1 width=8)
--            ->  Gather  (cost=1000.43..107142.27 rows=2 width=4)
--         Workers Planned: 2
--         ->  Nested Loop  (cost=0.43..106142.07 rows=1 width=4)
--               ->  Parallel Seq Scan on ticket t  (cost=0.00..106137.60 rows=1 width=8)
--                     Filter: (session_id = 8)
--               ->  Index Only Scan using session_pk on session s  (cost=0.43..4.45 rows=1 width=4)
--                     Index Cond: (id = 8)

-- Index for session_id column in ticket table
create index idx_ticket_session_id on ticket(session_id);

-- Index Scan using index instead primary key after index creation
-- Aggregate  (cost=16.95..16.96 rows=1 width=8)
--            ->  Nested Loop  (cost=0.87..16.94 rows=2 width=4)
--         ->  Index Only Scan using session_pk on session s  (cost=0.43..4.45 rows=1 width=4)
--               Index Cond: (id = 8)
--         ->  Index Scan using idx_ticket_session_id on ticket t  (cost=0.43..12.47 rows=2 width=8)
--               Index Cond: (session_id = 8)
