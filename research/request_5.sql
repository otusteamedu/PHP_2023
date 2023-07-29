-- 5. Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
explain
select sc.row, sc."column", bool(t.cost) as busy
from scheme sc
         inner join session s on sc.hall_id = s.hall_id
         left join ticket t on s.id = t.session_id and t.scheme_id = sc.id
where s.id = 1233
order by busy;

-- 10_000
-- Sort  (cost=453.52..456.02 rows=1000 width=9)
--       Sort Key: (bool(t.cost))
--   ->  Hash Left Join  (cost=191.27..403.69 rows=1000 width=9)
--         Hash Cond: ((s.id = t.session_id) AND (sc.id = t.scheme_id))
--         ->  Hash Join  (cost=8.31..200.69 rows=1000 width=16)
--               Hash Cond: (sc.hall_id = s.hall_id)
--               ->  Seq Scan on scheme sc  (cost=0.00..155.00 rows=10000 width=16)
--               ->  Hash  (cost=8.30..8.30 rows=1 width=8)
--                     ->  Index Scan using session_pk on session s  (cost=0.29..8.30 rows=1 width=8)
--                           Index Cond: (id = 8)
--         ->  Hash  (cost=182.19..182.19 rows=51 width=12)
--               ->  Seq Scan on ticket t  (cost=0.00..182.19 rows=51 width=12)
--                     Filter: (session_id = 8)

-- 10_000_000
-- Gather Merge  (cost=268617.46..365837.91 rows=833260 width=9)
--   Workers Planned: 2
--   ->  Sort  (cost=267617.44..268659.01 rows=416630 width=9)
--         Sort Key: (bool(t.cost))
--         ->  Parallel Hash Left Join  (cost=106146.08..221605.84 rows=416630 width=9)
--               Hash Cond: ((s.id = t.session_id) AND (sc.id = t.scheme_id))
--               ->  Hash Join  (cost=8.46..111301.91 rows=416630 width=16)
--                     Hash Cond: (sc.hall_id = s.hall_id)
--                     ->  Parallel Seq Scan on scheme sc  (cost=0.00..95721.08 rows=4166608 width=16)
--                     ->  Hash  (cost=8.45..8.45 rows=1 width=8)
--                           ->  Index Scan using session_pk on session s  (cost=0.43..8.45 rows=1 width=8)
--                                 Index Cond: (id = 8)
--               ->  Parallel Hash  (cost=106137.60..106137.60 rows=1 width=12)
--                     ->  Parallel Seq Scan on ticket t  (cost=0.00..106137.60 rows=1 width=12)
--                           Filter: (session_id = 8)

-- There is where condition with primary key. So it's no need to make index on it