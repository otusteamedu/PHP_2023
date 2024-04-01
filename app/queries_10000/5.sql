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

-- Sort  (cost=601.47..601.48 rows=1 width=612) (actual time=3.636..3.636 rows=1 loops=1)
-- "  Sort Key: seats.""row"", seats.place"
--   Sort Method: quicksort  Memory: 25kB
--   ->  Nested Loop  (cost=400.83..601.46 rows=1 width=612) (actual time=3.628..3.631 rows=1 loops=1)
--         ->  Nested Loop  (cost=400.68..601.29 rows=1 width=77) (actual time=3.622..3.625 rows=1 loops=1)
--               Join Filter: (sessions.hall_id = halls.id)
--               ->  Nested Loop  (cost=400.40..600.93 rows=1 width=44) (actual time=3.618..3.620 rows=1 loops=1)
--                     ->  Hash Right Join  (cost=400.11..592.62 rows=1 width=33) (actual time=3.611..3.614 rows=1 loops=1)
--                           Hash Cond: (orders.ticket_id = tickets.id)
--                           ->  Seq Scan on orders  (cost=0.00..155.00 rows=10000 width=8) (actual time=0.006..0.529 rows=10000 loops=1)
--                           ->  Hash  (cost=400.10..400.10 rows=1 width=33) (actual time=2.496..2.496 rows=1 loops=1)
--                                 Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                                 ->  Hash Join  (cost=198.59..400.10 rows=1 width=33) (actual time=2.493..2.494 rows=1 loops=1)
--                                       Hash Cond: (tickets.seats_id = seats.id)
--                                       ->  Seq Scan on tickets  (cost=0.00..164.00 rows=10000 width=13) (actual time=0.008..0.525 rows=10000 loops=1)
--                                       ->  Hash  (cost=198.58..198.58 rows=1 width=28) (actual time=1.233..1.233 rows=1 loops=1)
--                                             Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                                             ->  Hash Join  (cost=8.31..198.58 rows=1 width=28) (actual time=0.025..1.232 rows=1 loops=1)
--                                                   Hash Cond: (seats.halls_id = sessions.hall_id)
--                                                   ->  Seq Scan on seats  (cost=0.00..164.00 rows=10000 width=20) (actual time=0.004..0.519 rows=10000 loops=1)
--                                                   ->  Hash  (cost=8.30..8.30 rows=1 width=8) (actual time=0.010..0.010 rows=1 loops=1)
--                                                         Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                                                         ->  Index Scan using sessions_pkey on sessions  (cost=0.29..8.30 rows=1 width=8) (actual time=0.006..0.006 rows=1 loops=1)
--                                                               Index Cond: (id = 1)
--                     ->  Index Scan using movies_pkey on movies  (cost=0.29..8.30 rows=1 width=19) (actual time=0.005..0.005 rows=1 loops=1)
--                           Index Cond: (id = sessions.movie_id)
--               ->  Index Scan using halls_pkey on halls  (cost=0.29..0.35 rows=1 width=45) (actual time=0.004..0.004 rows=1 loops=1)
--                     Index Cond: (id = seats.halls_id)
--         ->  Index Scan using seats_types_pkey on seats_types  (cost=0.14..0.17 rows=1 width=520) (actual time=0.005..0.005 rows=1 loops=1)
--               Index Cond: (id = seats.seats_types_id)
-- Planning Time: 1.156 ms
-- Execution Time: 3.712 ms

CREATE INDEX ON sessions (movie_id);
CREATE INDEX ON sessions (hall_id);
CREATE INDEX ON seats (halls_id);
CREATE INDEX ON tickets (seats_id);
CREATE INDEX ON orders (ticket_id);

-- Sort  (cost=26.14..26.15 rows=1 width=612) (actual time=0.031..0.031 rows=1 loops=1)
-- "  Sort Key: seats.""row"", seats.place"
--   Sort Method: quicksort  Memory: 25kB
--   ->  Nested Loop Left Join  (cost=1.86..26.13 rows=1 width=612) (actual time=0.025..0.026 rows=1 loops=1)
--         ->  Nested Loop  (cost=1.57..25.78 rows=1 width=589) (actual time=0.022..0.023 rows=1 loops=1)
--               ->  Nested Loop  (cost=1.29..25.43 rows=1 width=584) (actual time=0.020..0.021 rows=1 loops=1)
--                     ->  Nested Loop  (cost=1.14..25.26 rows=1 width=72) (actual time=0.016..0.017 rows=1 loops=1)
--                           Join Filter: (sessions.hall_id = seats.halls_id)
--                           ->  Nested Loop  (cost=0.86..24.91 rows=1 width=64) (actual time=0.014..0.014 rows=1 loops=1)
--                                 ->  Nested Loop  (cost=0.57..16.61 rows=1 width=19) (actual time=0.010..0.010 rows=1 loops=1)
--                                       ->  Index Scan using sessions_pkey on sessions  (cost=0.29..8.30 rows=1 width=8) (actual time=0.006..0.006 rows=1 loops=1)
--                                             Index Cond: (id = 1)
--                                       ->  Index Scan using movies_pkey on movies  (cost=0.29..8.30 rows=1 width=19) (actual time=0.002..0.002 rows=1 loops=1)
--                                             Index Cond: (id = sessions.movie_id)
--                                 ->  Index Scan using halls_pkey on halls  (cost=0.29..8.30 rows=1 width=45) (actual time=0.004..0.004 rows=1 loops=1)
--                                       Index Cond: (id = sessions.hall_id)
--                           ->  Index Scan using seats_halls_id_idx on seats  (cost=0.29..0.34 rows=1 width=20) (actual time=0.001..0.002 rows=1 loops=1)
--                                 Index Cond: (halls_id = halls.id)
--                     ->  Index Scan using seats_types_pkey on seats_types  (cost=0.14..0.17 rows=1 width=520) (actual time=0.003..0.003 rows=1 loops=1)
--                           Index Cond: (id = seats.seats_types_id)
--               ->  Index Scan using tickets_seats_id_idx on tickets  (cost=0.29..0.34 rows=1 width=13) (actual time=0.001..0.002 rows=1 loops=1)
--                     Index Cond: (seats_id = seats.id)
--         ->  Index Scan using orders_ticket_id_idx on orders  (cost=0.29..0.34 rows=1 width=8) (actual time=0.002..0.003 rows=1 loops=1)
--               Index Cond: (ticket_id = tickets.id)
-- Planning Time: 1.872 ms
-- Execution Time: 0.076 ms