-- 4. Поиск 3 самых прибыльных фильмов за неделю
explain
select f.name, sum(cost) as sum
from ticket
         inner join session s on s.id = ticket.session_id
         inner join film f on f.id = s.film_id
where date >= (current_date - interval '7 day')
group by f.name
order by sum
        desc
limit 3;

-- 10_000
-- Limit  (cost=1070.31..1070.32 rows=3 width=25)
--        ->  Sort  (cost=1070.31..1095.31 rows=10000 width=25)
--         Sort Key: (sum(ticket.cost)) DESC
--         ->  HashAggregate  (cost=841.07..941.07 rows=10000 width=25)
--               Group Key: f.name
--               ->  Hash Join  (cost=580.00..790.19 rows=10175 width=21)
--                     Hash Cond: (s.film_id = f.id)
--                     ->  Hash Join  (cost=289.00..472.47 rows=10175 width=8)
--                           Hash Cond: (ticket.session_id = s.id)
--                           ->  Seq Scan on ticket  (cost=0.00..156.75 rows=10175 width=8)
--                           ->  Hash  (cost=164.00..164.00 rows=10000 width=8)
--                                 ->  Seq Scan on session s  (cost=0.00..164.00 rows=10000 width=8)
--                     ->  Hash  (cost=166.00..166.00 rows=10000 width=21)
--                           ->  Seq Scan on film f  (cost=0.00..166.00 rows=10000 width=21)

-- 10_000_000
-- Limit  (cost=2506506.50..2506506.50 rows=3 width=25)
--        ->  Sort  (cost=2506506.50..2530439.45 rows=9573181 width=25)
--         Sort Key: (sum(ticket.cost)) DESC
--         ->  Finalize GroupAggregate  (cost=1210601.50..2382774.93 rows=9573181 width=25)
--               Group Key: f.name
--               ->  Gather Merge  (cost=1210601.50..2245377.04 rows=8333216 width=25)
--                     Workers Planned: 2
--                     ->  Partial GroupAggregate  (cost=1209601.48..1282517.12 rows=4166608 width=25)
--                           Group Key: f.name
--                           ->  Sort  (cost=1209601.48..1220018.00 rows=4166608 width=21)
--                                 Sort Key: f.name
--                                 ->  Parallel Hash Join  (cost=357188.95..580575.72 rows=4166608 width=21)
--                                       Hash Cond: (s.film_id = f.id)
--                                       ->  Parallel Hash Join  (cost=173723.08..329210.51 rows=4166608 width=8)
--                                             Hash Cond: (ticket.session_id = s.id)
--                                             ->  Parallel Seq Scan on ticket  (cost=0.00..95721.08 rows=4166608 width=8)
--                                             ->  Parallel Hash  (cost=105362.15..105362.15 rows=4166715 width=8)
--                                                   ->  Parallel Seq Scan on session s  (cost=0.00..105362.15 rows=4166715 width=8)
--                                       ->  Parallel Hash  (cost=106983.16..106983.16 rows=4165816 width=21)
--                                             ->  Parallel Seq Scan on film f  (cost=0.00..106983.16 rows=4165816 width=21)

-- Index for date column in session table
create index idx_session_date on session(date);

-- Bitmap Index Scan instead parallel seq scan after index creation
-- Limit  (cost=329663.30..329663.31 rows=3 width=25)
--        ->  Sort  (cost=329663.30..330120.88 rows=183032 width=25)
--         Sort Key: (sum(ticket.cost)) DESC
--         ->  Finalize GroupAggregate  (cost=305764.81..327297.65 rows=183032 width=25)
--               Group Key: f.name
--               ->  Gather Merge  (cost=305764.81..324704.70 rows=152526 width=25)
--                     Workers Planned: 2
--                     ->  Partial GroupAggregate  (cost=304764.79..306099.39 rows=76263 width=25)
--                           Group Key: f.name
--                           ->  Sort  (cost=304764.79..304955.44 rows=76263 width=21)
--                                 Sort Key: f.name
--                                 ->  Parallel Hash Join  (cost=175657.62..298580.35 rows=76263 width=21)
--                                       Hash Cond: (f.id = s.film_id)
--                                       ->  Parallel Seq Scan on film f  (cost=0.00..106983.16 rows=4165816 width=21)
--                                       ->  Parallel Hash  (cost=174704.33..174704.33 rows=76263 width=8)
--                                             ->  Parallel Hash Join  (cost=68045.90..174704.33 rows=76263 width=8)
--                                                   Hash Cond: (ticket.session_id = s.id)
--                                                   ->  Parallel Seq Scan on ticket  (cost=0.00..95721.08 rows=4166608 width=8)
--                                                   ->  Parallel Hash  (cost=67092.59..67092.59 rows=76265 width=8)
--                                                         ->  Parallel Bitmap Heap Scan on session s  (cost=2062.96..67092.59 rows=76265 width=8)
--                                                               Recheck Cond: (date >= (CURRENT_DATE - '7 days'::interval))
--                                                               ->  Bitmap Index Scan on idx_session_date  (cost=0.00..2017.20 rows=183035 width=0)
--                                                                     Index Cond: (date >= (CURRENT_DATE - '7 days'::interval))