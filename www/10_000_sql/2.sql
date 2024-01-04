EXPLAIN ANALYSE
SELECT
    count(tickets.id)
FROM
    tickets
        LEFT JOIN sessions ON tickets.session_id = sessions.id
WHERE
    tickets.date_purchase BETWEEN date_trunc('week', now())
        AND (date_trunc('week', now()) + '6 days 23 hours 59 minutes'::interval)
  AND tickets.status = 'sold';


-- Aggregate  (cost=384.00..384.01 rows=1 width=8) (actual time=1.528..1.529 rows=1 loops=1)
--    ->  Seq Scan on tickets  (cost=0.00..384.00 rows=1 width=4) (actual time=1.527..1.527 rows=0 loops=1)
--          Filter: ((status = 'sold'::bpchar) AND (date_purchase >= date_trunc('week'::text, now())) AND (date_p
-- urchase <= (date_trunc('week'::text, now()) + '6 days 23:59:00'::interval)))
--          Rows Removed by Filter: 10000
--  Planning Time: 0.159 ms
--  Execution Time: 1.540 ms

-- create index --
create index ticket_sold_status on tickets (status)
    where status = 'sold';
--
-- Aggregate  (cost=221.60..221.61 rows=1 width=8) (actual time=1.066..1.067 rows=1 loops=1)
--    ->  Bitmap Heap Scan on tickets  (cost=37.04..221.60 rows=1 width=4) (actual time=1.064..1.065 rows=0 loops
-- =1)
--          Recheck Cond: (status = 'sold'::bpchar)
--          Filter: ((date_purchase >= date_trunc('week'::text, now())) AND (date_purchase <= (date_trunc('week':
-- :text, now()) + '6 days 23:59:00'::interval)))
--          Rows Removed by Filter: 3352
--          Heap Blocks: exact=84
--          ->  Bitmap Index Scan on ticket_sold_status  (cost=0.00..37.04 rows=3352 width=0) (actual time=0.057.
-- .0.057 rows=3352 loops=1)
--  Planning Time: 0.206 ms
--  Execution Time: 1.086 ms
