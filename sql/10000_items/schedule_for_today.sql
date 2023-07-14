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
-- Nested Loop  (cost=17.87..41.54 rows=4 width=27) (actual time=0.090..0.264 rows=5 loops=1)
--   ->  Merge Join  (cost=17.70..21.38 rows=4 width=27) (actual time=0.077..0.219 rows=5 loops=1)
--         Merge Cond: (films.id = sessions.film_id)
--         ->  Index Scan using films_pkey on films  (cost=0.29..337.29 rows=10000 width=15) (actual time=0.007..0.078 rows=60 loops=1)
--         ->  Sort  (cost=17.42..17.43 rows=4 width=20) (actual time=0.044..0.055 rows=5 loops=1)
--               Sort Key: sessions.film_id
--               Sort Method: quicksort  Memory: 25kB
--               ->  Bitmap Heap Scan on sessions  (cost=4.32..17.38 rows=4 width=20) (actual time=0.019..0.033 rows=5 loops=1)
--                     Recheck Cond: (date_start = CURRENT_DATE)
--                     Heap Blocks: exact=5
--                     ->  Bitmap Index Scan on idx_date_start_film_id_hall_id  (cost=0.00..4.32 rows=4 width=0) (actual time=0.013..0.014 rows=5 loops=1)
--                           Index Cond: (date_start = CURRENT_DATE)
--   ->  Memoize  (cost=0.17..6.18 rows=1 width=8) (actual time=0.004..0.004 rows=1 loops=5)
--         Cache Key: sessions.hall_id
--         Cache Mode: logical
--         Hits: 3  Misses: 2  Evictions: 0  Overflows: 0  Memory Usage: 1kB
--         ->  Index Scan using halls_pkey on halls  (cost=0.15..6.17 rows=1 width=8) (actual time=0.004..0.004 rows=1 loops=2)
--               Index Cond: (id = sessions.hall_id)
-- Planning Time: 0.336 ms
-- Execution Time: 0.304 ms

-- Вывод: Индексы значительно повлияли на производительность запроса