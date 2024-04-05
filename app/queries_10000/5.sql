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

-- Sort  (cost=428.95..428.95 rows=1 width=612) (actual time=4.123..4.132 rows=334 loops=1)
-- "  Sort Key: seats.""row"", seats.place"
--   Sort Method: quicksort  Memory: 71kB
--   ->  Nested Loop  (cost=199.30..428.94 rows=1 width=612) (actual time=1.368..3.987 rows=334 loops=1)
--         ->  Nested Loop  (cost=199.16..428.77 rows=1 width=77) (actual time=1.364..3.649 rows=334 loops=1)
--               Join Filter: (sessions.hall_id = halls.id)
--               ->  Nested Loop  (cost=198.87..428.40 rows=1 width=44) (actual time=1.359..3.205 rows=334 loops=1)
--                     ->  Hash Right Join  (cost=198.59..420.10 rows=1 width=33) (actual time=1.351..2.748 rows=334 loops=1)
--                           Hash Cond: (tickets.seats_id = seats.id)
--                           ->  Seq Scan on tickets  (cost=0.00..184.00 rows=10000 width=13) (actual time=0.005..0.546 rows=10000 loops=1)
--                           ->  Hash  (cost=198.58..198.58 rows=1 width=28) (actual time=1.335..1.335 rows=334 loops=1)
--                                 Buckets: 1024  Batches: 1  Memory Usage: 28kB
--                                 ->  Hash Join  (cost=8.31..198.58 rows=1 width=28) (actual time=0.027..1.284 rows=334 loops=1)
--                                       Hash Cond: (seats.halls_id = sessions.hall_id)
--                                       ->  Seq Scan on seats  (cost=0.00..164.00 rows=10000 width=20) (actual time=0.009..0.524 rows=10000 loops=1)
--                                       ->  Hash  (cost=8.30..8.30 rows=1 width=8) (actual time=0.012..0.012 rows=1 loops=1)
--                                             Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                                             ->  Index Scan using sessions_pkey on sessions  (cost=0.29..8.30 rows=1 width=8) (actual time=0.008..0.009 rows=1 loops=1)
--                                                   Index Cond: (id = 1)
--                     ->  Index Scan using movies_pkey on movies  (cost=0.29..8.30 rows=1 width=19) (actual time=0.001..0.001 rows=1 loops=334)
--                           Index Cond: (id = sessions.movie_id)
--               ->  Index Scan using halls_pkey on halls  (cost=0.29..0.35 rows=1 width=45) (actual time=0.001..0.001 rows=1 loops=334)
--                     Index Cond: (id = seats.halls_id)
--         ->  Index Scan using seats_types_pkey on seats_types  (cost=0.14..0.17 rows=1 width=520) (actual time=0.001..0.001 rows=1 loops=334)
--               Index Cond: (id = seats.seats_types_id)
-- Planning Time: 0.736 ms
-- Execution Time: 4.222 ms

CREATE INDEX ON sessions (movie_id);
CREATE INDEX ON sessions (hall_id);
CREATE INDEX ON seats (halls_id);
CREATE INDEX ON tickets (seats_id);
CREATE INDEX ON tickets (created_at);

-- Sort  (cost=35.76..35.77 rows=1 width=612) (actual time=1.442..1.451 rows=334 loops=1)
-- "  Sort Key: seats.""row"", seats.place"
--   Sort Method: quicksort  Memory: 71kB
--   ->  Nested Loop Left Join  (cost=1.57..35.75 rows=1 width=612) (actual time=0.071..1.311 rows=334 loops=1)
--         ->  Nested Loop  (cost=1.29..35.39 rows=1 width=584) (actual time=0.065..0.556 rows=334 loops=1)
--               ->  Nested Loop  (cost=1.14..35.22 rows=1 width=72) (actual time=0.058..0.232 rows=334 loops=1)
--                     Join Filter: (sessions.hall_id = seats.halls_id)
--                     ->  Nested Loop  (cost=0.86..24.91 rows=1 width=64) (actual time=0.027..0.028 rows=1 loops=1)
--                           ->  Nested Loop  (cost=0.57..16.61 rows=1 width=19) (actual time=0.018..0.019 rows=1 loops=1)
--                                 ->  Index Scan using sessions_pkey on sessions  (cost=0.29..8.30 rows=1 width=8) (actual time=0.009..0.010 rows=1 loops=1)
--                                       Index Cond: (id = 1)
--                                 ->  Index Scan using movies_pkey on movies  (cost=0.29..8.30 rows=1 width=19) (actual time=0.007..0.007 rows=1 loops=1)
--                                       Index Cond: (id = sessions.movie_id)
--                           ->  Index Scan using halls_pkey on halls  (cost=0.29..8.30 rows=1 width=45) (actual time=0.009..0.009 rows=1 loops=1)
--                                 Index Cond: (id = sessions.hall_id)
--                     ->  Index Scan using seats_halls_id_idx on seats  (cost=0.29..6.15 rows=333 width=20) (actual time=0.030..0.146 rows=334 loops=1)
--                           Index Cond: (halls_id = halls.id)
--               ->  Index Scan using seats_types_pkey on seats_types  (cost=0.14..0.17 rows=1 width=520) (actual time=0.001..0.001 rows=1 loops=334)
--                     Index Cond: (id = seats.seats_types_id)
--         ->  Index Scan using tickets_seats_id_idx on tickets  (cost=0.29..0.35 rows=1 width=13) (actual time=0.002..0.002 rows=1 loops=334)
--               Index Cond: (seats_id = seats.id)
-- Planning Time: 1.438 ms
-- Execution Time: 1.547 ms