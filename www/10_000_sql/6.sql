EXPLAIN ANALYSE
SELECT
    min(sp.price) as min_price,
    max(sp.price) as max_price
FROM
    session_price as sp
WHERE
    session_id = 1;

-- Aggregate  (cost=19.54..19.55 rows=1 width=16) (actual time=0.061..0.062 rows=1 loops=1)
--    ->  Seq Scan on session_price sp  (cost=0.00..19.52 rows=2 width=8) (actual time=0.006..0.059 rows=2 loops=
-- 1)
--          Filter: (session_id = 1)
--          Rows Removed by Filter: 1000
--  Planning Time: 0.166 ms
--  Execution Time: 0.076 ms

create index idx_price ON session_price(price);

-- Aggregate  (cost=19.54..19.55 rows=1 width=16) (actual time=0.061..0.061 rows=1 loops=1)
--    ->  Seq Scan on session_price sp  (cost=0.00..19.52 rows=2 width=8) (actual time=0.006..0.057 rows=2 loops=
-- 1)
--          Filter: (session_id = 1)
--          Rows Removed by Filter: 1000
--  Planning Time: 0.217 ms
--  Execution Time: 0.075 ms