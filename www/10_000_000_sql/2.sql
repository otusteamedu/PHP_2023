EXPLAIN ANALYSE
SELECT
    count(tickets.id)
FROM
    tickets
        LEFT JOIN sessions ON tickets.session_id = sessions.id
WHERE
    tickets.date_purchase >= '1701388800'
  AND tickets.date_purchase <= '1701907200'
  AND tickets.status = 'sold';


-- Aggregate  (cost=3970.26..3970.27 rows=1 width=8) (actual time=24.568..29.118 rows=1 loops=1)
--    ->  Gather  (cost=1000.00..3970.26 rows=1 width=4) (actual time=24.565..29.114 rows=0 loops=1)
--          Workers Planned: 1
--          Workers Launched: 1
--          ->  Parallel Seq Scan on tickets  (cost=0.00..2970.16 rows=1 width=4) (actual time=8.252..8.252 rows=
-- 0 loops=2)
--                Filter: ((status = 'sold'::bpchar) AND (date_purchase >= date_trunc('week'::text, now())) AND (
-- date_purchase <= (date_trunc('week'::text, now()) + '6 days 23:59:00'::interval)))
--                Rows Removed by Filter: 55000
--  Planning Time: 0.152 ms
--  Execution Time: 29.133 ms

-- create index --
create index ticket_sold_status on tickets (status)
    where status = 'sold';

-- Aggregate  (cost=2446.43..2446.44 rows=1 width=8) (actual time=11.618..11.619 rows=1 loops=1)
--    ->  Bitmap Heap Scan on tickets  (cost=319.31..2446.43 rows=1 width=4) (actual time=11.616..11.616 rows=0 l
-- oops=1)
--          Recheck Cond: (status = 'sold'::bpchar)
--          Filter: ((date_purchase >= date_trunc('week'::text, now())) AND (date_purchase <= (date_trunc('week':
-- :text, now()) + '6 days 23:59:00'::interval)))
--          Rows Removed by Filter: 36750
--          Heap Blocks: exact=1029
--          ->  Bitmap Index Scan on ticket_sold_status  (cost=0.00..319.31 rows=36604 width=0) (actual time=0.74
-- 7..0.747 rows=36750 loops=1)
--  Planning Time: 0.216 ms
--  Execution Time: 11.635 ms
