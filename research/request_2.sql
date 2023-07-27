-- 2. Подсчёт проданных билетов за неделю
explain
select count(s.id) as "Weekly sold count"
from ticket t
         inner join session s on s.id = t.session_id
where date >= (current_date - interval '7 day');

-- 10_000
-- Aggregate  (cost=425.42..425.43 rows=1 width=8)
--            ->  Hash Join  (cost=241.45..424.92 rows=199 width=4)
--         Hash Cond: (t.session_id = s.id)
--         ->  Seq Scan on ticket t  (cost=0.00..156.75 rows=10175 width=4)
--         ->  Hash  (cost=239.00..239.00 rows=196 width=4)
--               ->  Seq Scan on session s  (cost=0.00..239.00 rows=196 width=4)
--                     Filter: (date >= (CURRENT_DATE - '7 days'::interval))

-- 10_000_000
-- Finalize Aggregate  (cost=245415.12..245415.13 rows=1 width=8)
--   ->  Gather  (cost=245414.90..245415.11 rows=2 width=8)
--         Workers Planned: 2
--         ->  Partial Aggregate  (cost=244414.90..244414.91 rows=1 width=8)
--               ->  Parallel Hash Join  (cost=137565.82..244224.25 rows=76263 width=4)
--                     Hash Cond: (t.session_id = s.id)
--                     ->  Parallel Seq Scan on ticket t  (cost=0.00..95721.08 rows=4166608 width=4)
--                     ->  Parallel Hash  (cost=136612.51..136612.51 rows=76265 width=4)
--                           ->  Parallel Seq Scan on session s  (cost=0.00..136612.51 rows=76265 width=4)
--                                 Filter: (date >= (CURRENT_DATE - '7 days'::interval))

-- Index for date column in session table
create index idx_session_date on session(date);

-- Bitmap Index Scan instead parallel seq scan after index creation
-- Finalize Aggregate  (cost=175895.21..175895.22 rows=1 width=8)
--   ->  Gather  (cost=175894.99..175895.20 rows=2 width=8)
--         Workers Planned: 2
--         ->  Partial Aggregate  (cost=174894.99..174895.00 rows=1 width=8)
--               ->  Parallel Hash Join  (cost=68045.90..174704.33 rows=76263 width=4)
--                     Hash Cond: (t.session_id = s.id)
--                     ->  Parallel Seq Scan on ticket t  (cost=0.00..95721.08 rows=4166608 width=4)
--                     ->  Parallel Hash  (cost=67092.59..67092.59 rows=76265 width=4)
--                           ->  Parallel Bitmap Heap Scan on session s  (cost=2062.96..67092.59 rows=76265 width=4)
--                                 Recheck Cond: (date >= (CURRENT_DATE - '7 days'::interval))
--                                 ->  Bitmap Index Scan on idx_session_date  (cost=0.00..2017.20 rows=183035 width=0)
--                                       Index Cond: (date >= (CURRENT_DATE - '7 days'::interval))