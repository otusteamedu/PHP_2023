-- Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
EXPLAIN ANALYSE
SELECT halls.name                                                                            AS "Зал",
       halls.description                                                                     AS "Описание зала",
       movies.title                                                                          AS "Сеанс фильма",
       seats.row                                                                             AS "Ряд",
       seats.place                                                                           AS "Место",
       seats_types.title                                                                     AS "Тип кресла",
       CASE WHEN tickets.id IS NOT NULL THEN 'Занято' ELSE CAST(tickets.price AS VARCHAR) END AS "Цена"
FROM sessions
         JOIN movies ON sessions.movie_id = movies.id
         JOIN halls ON sessions.hall_id = halls.id
         JOIN seats ON halls.id = seats.halls_id
         JOIN seats_types ON seats.seats_types_id = seats_types.id
         LEFT JOIN tickets ON seats.id = tickets.seats_id
WHERE sessions.id = 1
ORDER BY seats.row, seats.place;

-- Sort  (cost=338150.22..338150.23 rows=1 width=621) (actual time=2071.037..2071.038 rows=1 loops=1)
-- "  Sort Key: seats.""row"", seats.place"
--   Sort Method: quicksort  Memory: 25kB
--   ->  Nested Loop  (cost=117308.08..338150.21 rows=1 width=621) (actual time=2071.014..2071.019 rows=1 loops=1)
--         ->  Nested Loop  (cost=117307.94..338150.05 rows=1 width=86) (actual time=2068.666..2068.671 rows=1 loops=1)
--               Join Filter: (sessions.hall_id = halls.id)
--               ->  Nested Loop  (cost=117307.50..338149.53 rows=1 width=47) (actual time=2068.656..2068.661 rows=1 loops=1)
--                     ->  Hash Right Join  (cost=117307.07..338141.08 rows=1 width=33) (actual time=2068.632..2068.637 rows=1 loops=1)
--                           Hash Cond: (tickets.seats_id = seats.id)
--                           ->  Seq Scan on tickets  (cost=0.00..183334.00 rows=10000000 width=13) (actual time=0.050..789.284 rows=10000000 loops=1)
--                           ->  Hash  (cost=117307.05..117307.05 rows=1 width=28) (actual time=551.100..551.100 rows=1 loops=1)
--                                 Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                                 ->  Gather  (cost=1008.47..117307.05 rows=1 width=28) (actual time=0.728..551.141 rows=1 loops=1)
--                                       Workers Planned: 2
--                                       Workers Launched: 2
--                                       ->  Hash Join  (cost=8.46..116306.95 rows=1 width=28) (actual time=345.860..529.208 rows=0 loops=3)
--                                             Hash Cond: (seats.halls_id = sessions.hall_id)
--                                             ->  Parallel Seq Scan on seats  (cost=0.00..105361.13 rows=4166613 width=20) (actual time=0.033..290.204 rows=3333333 loops=3)
--                                             ->  Hash  (cost=8.45..8.45 rows=1 width=8) (actual time=0.040..0.040 rows=1 loops=3)
--                                                   Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                                                   ->  Index Scan using sessions_pkey on sessions  (cost=0.43..8.45 rows=1 width=8) (actual time=0.034..0.035 rows=1 loops=3)
--                                                         Index Cond: (id = 1)
--                     ->  Index Scan using movies_pkey on movies  (cost=0.43..8.45 rows=1 width=22) (actual time=0.019..0.019 rows=1 loops=1)
--                           Index Cond: (id = sessions.movie_id)
--               ->  Index Scan using halls_pkey on halls  (cost=0.43..0.50 rows=1 width=51) (actual time=0.008..0.008 rows=1 loops=1)
--                     Index Cond: (id = seats.halls_id)
--         ->  Index Scan using seats_types_pkey on seats_types  (cost=0.14..0.16 rows=1 width=520) (actual time=2.345..2.345 rows=1 loops=1)
--               Index Cond: (id = seats.seats_types_id)
-- Planning Time: 3.312 ms
-- Execution Time: 2071.222 ms

CREATE INDEX ON sessions (movie_id);
CREATE INDEX ON sessions (hall_id);
CREATE INDEX ON seats (halls_id);
CREATE INDEX ON tickets (seats_id);
CREATE INDEX ON tickets (created_at);

-- Sort  (cost=26.54..26.55 rows=1 width=621) (actual time=0.041..0.041 rows=1 loops=1)
-- "  Sort Key: seats.""row"", seats.place"
--   Sort Method: quicksort  Memory: 25kB
--   ->  Nested Loop Left Join  (cost=2.32..26.53 rows=1 width=621) (actual time=0.032..0.033 rows=1 loops=1)
--         ->  Nested Loop  (cost=1.89..26.02 rows=1 width=593) (actual time=0.027..0.027 rows=1 loops=1)
--               ->  Nested Loop  (cost=1.74..25.86 rows=1 width=81) (actual time=0.023..0.024 rows=1 loops=1)
--                     Join Filter: (sessions.hall_id = seats.halls_id)
--                     ->  Nested Loop  (cost=1.30..25.36 rows=1 width=73) (actual time=0.019..0.019 rows=1 loops=1)
--                           ->  Nested Loop  (cost=0.87..16.91 rows=1 width=22) (actual time=0.016..0.016 rows=1 loops=1)
--                                 ->  Index Scan using sessions_pkey on sessions  (cost=0.43..8.45 rows=1 width=8) (actual time=0.009..0.009 rows=1 loops=1)
--                                       Index Cond: (id = 1)
--                                 ->  Index Scan using movies_pkey on movies  (cost=0.43..8.45 rows=1 width=22) (actual time=0.005..0.005 rows=1 loops=1)
--                                       Index Cond: (id = sessions.movie_id)
--                           ->  Index Scan using halls_pkey on halls  (cost=0.43..8.45 rows=1 width=51) (actual time=0.003..0.003 rows=1 loops=1)
--                                 Index Cond: (id = sessions.hall_id)
--                     ->  Index Scan using seats_halls_id_idx on seats  (cost=0.43..0.49 rows=1 width=20) (actual time=0.003..0.003 rows=1 loops=1)
--                           Index Cond: (halls_id = halls.id)
--               ->  Index Scan using seats_types_pkey on seats_types  (cost=0.14..0.16 rows=1 width=520) (actual time=0.003..0.003 rows=1 loops=1)
--                     Index Cond: (id = seats.seats_types_id)
--         ->  Index Scan using tickets_seats_id_idx on tickets  (cost=0.43..0.50 rows=1 width=13) (actual time=0.004..0.005 rows=1 loops=1)
--               Index Cond: (seats_id = seats.id)
-- Planning Time: 2.273 ms
-- Execution Time: 0.115 ms