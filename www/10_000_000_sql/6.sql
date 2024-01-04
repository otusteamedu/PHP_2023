EXPLAIN ANALYSE
SELECT
    min(sp.price) as min_price,
    max(sp.price) as max_price
FROM
    session_price as sp
WHERE
    session_id = 1;

-- Aggregate  (cost=1906.55..1906.56 rows=1 width=16) (actual time=5.129..5.130 rows=1 loops=1)
--    ->  Seq Scan on session_price sp  (cost=0.00..1906.53 rows=4 width=8) (actual time=0.015..5.124 rows=2 loop
-- s=1)
--          Filter: (session_id = 1)
--          Rows Removed by Filter: 101000
--  Planning Time: 0.069 ms
--  Execution Time: 5.147 ms

create index idx_price ON session_price(price);

-- Aggregate  (cost=1906.55..1906.56 rows=1 width=16) (actual time=5.121..5.122 rows=1 loops=1)
--    ->  Seq Scan on session_price sp  (cost=0.00..1906.53 rows=4 width=8) (actual time=0.007..5.118 rows=2 loop
-- s=1)
--          Filter: (session_id = 1)
--          Rows Removed by Filter: 101000
--  Planning Time: 0.217 ms
--  Execution Time: 5.139 ms