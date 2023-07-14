explain analyse SELECT sessions.id, films.name AS film_name, halls.number AS hall_number, sessions.time_start
FROM sessions
     JOIN films ON films.id = sessions.film_id
     JOIN halls ON halls.id = sessions.hall_id
WHERE sessions.date_start = CURRENT_DATE;

-- Результат
-- Nested Loop  (cost=214.49..238.16 rows=4 width=27) (actual time=2.907..3.208 rows=5 loops=1)
--   ->  Merge Join  (cost=214.32..218.00 rows=4 width=27) (actual time=2.844..3.087 rows=5 loops=1)
--         Merge Cond: (films.id = sessions.film_id)
--         ->  Index Scan using films_pkey on films  (cost=0.29..337.29 rows=10000 width=15) (actual time=0.024..0.149 rows=60 loops=1)
--         ->  Sort  (cost=214.04..214.05 rows=4 width=20) (actual time=2.768..2.783 rows=5 loops=1)
--               Sort Key: sessions.film_id
--               Sort Method: quicksort  Memory: 25kB
--               ->  Seq Scan on sessions  (cost=0.00..214.00 rows=4 width=20) (actual time=0.123..2.739 rows=5 loops=1)
--                     Filter: (date_start = CURRENT_DATE)
--                     Rows Removed by Filter: 9995
--   ->  Memoize  (cost=0.17..6.18 rows=1 width=8) (actual time=0.014..0.016 rows=1 loops=5)
--         Cache Key: sessions.hall_id
--         Cache Mode: logical
--         Hits: 3  Misses: 2  Evictions: 0  Overflows: 0  Memory Usage: 1kB
--         ->  Index Scan using halls_pkey on halls  (cost=0.15..6.17 rows=1 width=8) (actual time=0.025..0.026 rows=1 loops=2)
--               Index Cond: (id = sessions.hall_id)
-- Planning Time: 0.787 ms
-- Execution Time: 3.294 ms

-- Индекс на столбецы date_start, film_id, hall_id таблицы sessions:
CREATE INDEX idx_date_start_film_id_hall_id ON sessions (date_start, film_id, hall_id);

explain analyse SELECT sessions.id, films.name AS film_name, halls.number AS hall_number, sessions.time_start
FROM sessions
     JOIN films ON films.id = sessions.film_id
     JOIN halls ON halls.id = sessions.hall_id
WHERE sessions.date_start = CURRENT_DATE;

-- Результат после приминения индексов:
-- Nested Loop  (cost=27.31..49.12 rows=7 width=27) (actual time=0.242..0.629 rows=11 loops=1)
--   ->  Merge Join  (cost=27.15..32.00 rows=7 width=27) (actual time=0.200..0.486 rows=11 loops=1)
--         Merge Cond: (films.id = sessions.film_id)
--         ->  Index Scan using films_pkey on films  (cost=0.28..45.27 rows=1000 width=15) (actual time=0.010..0.172 rows=101 loops=1)
--         ->  Sort  (cost=26.87..26.89 rows=7 width=20) (actual time=0.084..0.110 rows=11 loops=1)
--               Sort Key: sessions.film_id
--               Sort Method: quicksort  Memory: 25kB
--               ->  Bitmap Heap Scan on sessions  (cost=4.34..26.78 rows=7 width=20) (actual time=0.029..0.064 rows=11 loops=1)
--                     Recheck Cond: (date_start = CURRENT_DATE)
--                     Heap Blocks: exact=10
--                     ->  Bitmap Index Scan on idx_date_start_film_id_hall_id  (cost=0.00..4.34 rows=7 width=0) (actual time=0.020..0.021 rows=11 loops=1)
--                           Index Cond: (date_start = CURRENT_DATE)
--   ->  Memoize  (cost=0.17..4.75 rows=1 width=8) (actual time=0.007..0.007 rows=1 loops=11)
--         Cache Key: sessions.hall_id
--         Cache Mode: logical
--         Hits: 7  Misses: 4  Evictions: 0  Overflows: 0  Memory Usage: 1kB
--         ->  Index Scan using halls_pkey on halls  (cost=0.15..4.74 rows=1 width=8) (actual time=0.010..0.011 rows=1 loops=4)
--               Index Cond: (id = sessions.hall_id)
-- Planning Time: 0.777 ms
-- Execution Time: 0.700 ms


-- Вывод: Индексы значительно повлияли на производительность запроса