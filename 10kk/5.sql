--Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
EXPLAIN ANALYSE
SELECT sih.row,
       sih.seats,
       CASE WHEN t.id is NOT NULL THEN 1 ELSE 0 END AS busy
from seats_in_halls as sih
         LEFT JOIN tickets as t on t.seat_in_hall_id = sih.id
where sih.hall_id = 1
    and t.showtime_id = 1
   or t.id is null;

-- Hash Right Join  (cost=28.50..19039.62 rows=90 width=8) (actual time=1.306..163.418 rows=79 loops=1)
--   Hash Cond: (t.seat_in_hall_id = sih.id)
--   Filter: (((sih.hall_id = 1) AND (t.showtime_id = 1)) OR (t.id IS NULL))
--   Rows Removed by Filter: 999921
--   ->  Seq Scan on tickets t  (cost=0.00..16370.00 rows=1000000 width=12) (actual time=0.005..49.179 rows=1000000 loops=1)
--   ->  Hash  (cost=16.00..16.00 rows=1000 width=12) (actual time=0.243..0.244 rows=1000 loops=1)
--         Buckets: 1024  Batches: 1  Memory Usage: 51kB
--         ->  Seq Scan on seats_in_halls sih  (cost=0.00..16.00 rows=1000 width=12) (actual time=0.012..0.125 rows=1000 loops=1)
-- Planning Time: 11.580 ms
-- Execution Time: 163.519 ms

create index idx_sessions_datetime on showtime (start_time);

-- Hash Right Join  (cost=28.50..19039.62 rows=90 width=8) (actual time=2.778..191.162 rows=79 loops=1)
--   Hash Cond: (t.seat_in_hall_id = sih.id)
--   Filter: (((sih.hall_id = 1) AND (t.showtime_id = 1)) OR (t.id IS NULL))
--   Rows Removed by Filter: 999921
--   ->  Seq Scan on tickets t  (cost=0.00..16370.00 rows=1000000 width=12) (actual time=0.057..57.128 rows=1000000 loops=1)
--   ->  Hash  (cost=16.00..16.00 rows=1000 width=12) (actual time=0.427..0.438 rows=1000 loops=1)
--         Buckets: 1024  Batches: 1  Memory Usage: 51kB
--         ->  Seq Scan on seats_in_halls sih  (cost=0.00..16.00 rows=1000 width=12) (actual time=0.026..0.213 rows=1000 loops=1)
-- Planning Time: 0.994 ms
-- Execution Time: 191.330 ms
