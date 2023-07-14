explain analyse SELECT f.name, s.date_start, s.time_start
FROM films f
     JOIN sessions s ON f.id = s.film_id
WHERE s.date_start = CURRENT_DATE;

-- Результат:
-- Merge Join  (cost=214.32..218.00 rows=4 width=23) (actual time=2.759..3.093 rows=6 loops=1)
--     Merge Cond: (f.id = s.film_id)
--     ->  Index Scan using films_pkey on films f  (cost=0.29..337.29 rows=10000 width=15) (actual time=0.017..0.199 rows=87 loops=1)
--     ->  Sort  (cost=214.04..214.05 rows=4 width=16) (actual time=2.655..2.674 rows=6 loops=1)
--     Sort Key: s.film_id
--     Sort Method: quicksort  Memory: 25kB
--     ->  Seq Scan on sessions s  (cost=0.00..214.00 rows=4 width=16) (actual time=0.285..2.629 rows=6 loops=1)
--     Filter: (date_start = CURRENT_DATE)
--     Rows Removed by Filter: 9994
--     Planning Time: 0.556 ms
--     Execution Time: 3.151 ms

-- Индекс на столбец date_start таблицы sessions:
CREATE INDEX idx_date_start ON sessions (date_start);

explain analyse SELECT f.name, s.date_start, s.time_start
FROM films f
         JOIN sessions s ON f.id = s.film_id
WHERE s.date_start = CURRENT_DATE;

-- Результат после приминения индексов:
-- Merge Join  (cost=17.70..21.38 rows=4 width=23) (actual time=0.216..0.557 rows=6 loops=1)
--     Merge Cond: (f.id = s.film_id)
--     ->  Index Scan using films_pkey on films f  (cost=0.29..337.29 rows=10000 width=15) (actual time=0.020..0.210 rows=87 loops=1)
--     ->  Sort  (cost=17.42..17.43 rows=4 width=16) (actual time=0.111..0.132 rows=6 loops=1)
--     Sort Key: s.film_id
--     Sort Method: quicksort  Memory: 25kB
--     ->  Bitmap Heap Scan on sessions s  (cost=4.32..17.38 rows=4 width=16) (actual time=0.051..0.086 rows=6 loops=1)
--     Recheck Cond: (date_start = CURRENT_DATE)
--     Heap Blocks: exact=5
--     ->  Bitmap Index Scan on idx_date_start  (cost=0.00..4.32 rows=4 width=0) (actual time=0.034..0.036 rows=6 loops=1)
--     Index Cond: (date_start = CURRENT_DATE)
--     Planning Time: 0.620 ms
--     Execution Time: 0.633 ms

-- Вывод: Индексы значительно повлияли на производительность запроса


