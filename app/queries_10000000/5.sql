-- Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
EXPLAIN ANALYSE
SELECT halls.name                                                                            AS "Зал",
       halls.description                                                                     AS "Описание зала",
       movies.title                                                                          AS "Сеанс фильма",
       seats.row                                                                             AS "Ряд",
       seats.place                                                                           AS "Место",
       seats_types.title                                                                     AS "Тип кресла",
       CASE WHEN orders.id IS NOT NULL THEN 'Занято' ELSE CAST(tickets.price AS VARCHAR) END AS "Цена"
FROM sessions
         JOIN movies ON sessions.movie_id = movies.id
         JOIN halls ON sessions.hall_id = halls.id
         JOIN seats ON halls.id = seats.halls_id
         JOIN seats_types ON seats.seats_types_id = seats_types.id
         JOIN tickets ON seats.id = tickets.seats_id
         LEFT JOIN orders ON orders.ticket_id = tickets.id
WHERE sessions.id = 1
ORDER BY seats.row, seats.place;

-- Sort  (cost=418665.20..418665.20 rows=1 width=621) (actual time=2516.752..2516.752 rows=1 loops=1)
-- "  Sort Key: seats.""row"", seats.place"
--   Sort Method: quicksort  Memory: 25kB
--   ->  Nested Loop  (cost=281391.27..418665.19 rows=1 width=621) (actual time=2364.655..2516.709 rows=1 loops=1)
--         ->  Nested Loop  (cost=281391.12..418665.02 rows=1 width=86) (actual time=2364.601..2516.654 rows=1 loops=1)
--               Join Filter: (sessions.hall_id = halls.id)
--               ->  Nested Loop  (cost=281390.69..418664.50 rows=1 width=47) (actual time=2364.590..2516.642 rows=1 loops=1)
--                     ->  Gather  (cost=281390.25..418656.05 rows=1 width=33) (actual time=2364.551..2686.704 rows=1 loops=1)
--                           Workers Planned: 2
--                           Workers Launched: 2
--                           ->  Parallel Hash Left Join  (cost=280390.25..417655.95 rows=1 width=33) (actual time=2407.595..2457.640 rows=0 loops=3)
--                                 Hash Cond: (tickets.id = orders.ticket_id)
--                                 ->  Parallel Hash Join  (cost=116308.25..237294.93 rows=1 width=33) (actual time=1204.247..1204.250 rows=0 loops=3)
--                                       Hash Cond: (tickets.seats_id = seats.id)
--                                       ->  Parallel Seq Scan on tickets  (cost=0.00..105361.67 rows=4166667 width=13) (actual time=0.212..291.565 rows=3333333 loops=3)
--                                       ->  Parallel Hash  (cost=116308.24..116308.24 rows=1 width=28) (actual time=541.656..541.656 rows=0 loops=3)
--                                             Buckets: 1024  Batches: 1  Memory Usage: 40kB
--                                             ->  Hash Join  (cost=8.46..116308.24 rows=1 width=28) (actual time=361.233..541.604 rows=0 loops=3)
--                                                   Hash Cond: (seats.halls_id = sessions.hall_id)
--                                                   ->  Parallel Seq Scan on seats  (cost=0.00..105362.15 rows=4166715 width=20) (actual time=0.052..300.403 rows=3333333 loops=3)
--                                                   ->  Hash  (cost=8.45..8.45 rows=1 width=8) (actual time=0.430..0.430 rows=1 loops=3)
--                                                         Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                                                         ->  Index Scan using sessions_pkey on sessions  (cost=0.43..8.45 rows=1 width=8) (actual time=0.423..0.424 rows=1 loops=3)
--                                                               Index Cond: (id = 1)
--                                 ->  Parallel Hash  (cost=95721.67..95721.67 rows=4166667 width=8) (actual time=918.049..918.049 rows=3333333 loops=3)
--                                       Buckets: 131072  Batches: 256  Memory Usage: 2624kB
--                                       ->  Parallel Seq Scan on orders  (cost=0.00..95721.67 rows=4166667 width=8) (actual time=0.052..399.002 rows=3333333 loops=3)
--                     ->  Index Scan using movies_pkey on movies  (cost=0.43..8.45 rows=1 width=22) (actual time=0.025..0.026 rows=1 loops=1)
--                           Index Cond: (id = sessions.movie_id)
--               ->  Index Scan using halls_pkey on halls  (cost=0.43..0.50 rows=1 width=51) (actual time=0.009..0.009 rows=1 loops=1)
--                     Index Cond: (id = seats.halls_id)
--         ->  Index Scan using seats_types_pkey on seats_types  (cost=0.14..0.16 rows=1 width=520) (actual time=0.051..0.051 rows=1 loops=1)
--               Index Cond: (id = seats.seats_types_id)
-- Planning Time: 16.176 ms
-- Execution Time: 2687.159 ms

CREATE INDEX ON sessions (movie_id);
CREATE INDEX ON sessions (hall_id);
CREATE INDEX ON seats (halls_id);
CREATE INDEX ON tickets (seats_id);
CREATE INDEX ON orders (ticket_id);

-- Sort  (cost=27.03..27.04 rows=1 width=621) (actual time=0.049..0.049 rows=1 loops=1)
-- "  Sort Key: seats.""row"", seats.place"
--   Sort Method: quicksort  Memory: 25kB
--   ->  Nested Loop Left Join  (cost=2.75..27.02 rows=1 width=621) (actual time=0.041..0.042 rows=1 loops=1)
--         ->  Nested Loop  (cost=2.32..26.52 rows=1 width=598) (actual time=0.034..0.035 rows=1 loops=1)
--               ->  Nested Loop  (cost=1.89..26.02 rows=1 width=593) (actual time=0.029..0.030 rows=1 loops=1)
--                     ->  Nested Loop  (cost=1.74..25.86 rows=1 width=81) (actual time=0.025..0.026 rows=1 loops=1)
--                           Join Filter: (sessions.hall_id = seats.halls_id)
--                           ->  Nested Loop  (cost=1.30..25.36 rows=1 width=73) (actual time=0.020..0.020 rows=1 loops=1)
--                                 ->  Nested Loop  (cost=0.87..16.91 rows=1 width=22) (actual time=0.015..0.015 rows=1 loops=1)
--                                       ->  Index Scan using sessions_pkey on sessions  (cost=0.43..8.45 rows=1 width=8) (actual time=0.007..0.007 rows=1 loops=1)
--                                             Index Cond: (id = 1)
--                                       ->  Index Scan using movies_pkey on movies  (cost=0.43..8.45 rows=1 width=22) (actual time=0.006..0.006 rows=1 loops=1)
--                                             Index Cond: (id = sessions.movie_id)
--                                 ->  Index Scan using halls_pkey on halls  (cost=0.43..8.45 rows=1 width=51) (actual time=0.004..0.004 rows=1 loops=1)
--                                       Index Cond: (id = sessions.hall_id)
--                           ->  Index Scan using seats_halls_id_idx on seats  (cost=0.43..0.49 rows=1 width=20) (actual time=0.005..0.005 rows=1 loops=1)
--                                 Index Cond: (halls_id = halls.id)
--                     ->  Index Scan using seats_types_pkey on seats_types  (cost=0.14..0.16 rows=1 width=520) (actual time=0.004..0.004 rows=1 loops=1)
--                           Index Cond: (id = seats.seats_types_id)
--               ->  Index Scan using tickets_seats_id_idx on tickets  (cost=0.43..0.49 rows=1 width=13) (actual time=0.004..0.005 rows=1 loops=1)
--                     Index Cond: (seats_id = seats.id)
--         ->  Index Scan using orders_ticket_id_idx on orders  (cost=0.43..0.49 rows=1 width=8) (actual time=0.006..0.006 rows=1 loops=1)
--               Index Cond: (ticket_id = tickets.id)
-- Planning Time: 2.613 ms
-- Execution Time: 0.114 ms