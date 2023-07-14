explain analyse SELECT f.name, s.date_start, s.time_start
FROM films f
     JOIN sessions s ON f.id = s.film_id
WHERE s.date_start = CURRENT_DATE;

-- Результат:
-- Merge Join  (cost=321.37..326.23 rows=7 width=23) (actual time=1.290..1.501 rows=11 loops=1)
--     Merge Cond: (f.id = s.film_id)
--     ->  Index Scan using films_pkey on films f  (cost=0.28..45.27 rows=1000 width=15) (actual time=0.005..0.137 rows=101 loops=1)
--     ->  Sort  (cost=321.10..321.12 rows=7 width=16) (actual time=1.198..1.214 rows=11 loops=1)
--     Sort Key: s.film_id
--     Sort Method: quicksort  Memory: 25kB
--     ->  Seq Scan on sessions s  (cost=0.00..321.00 rows=7 width=16) (actual time=0.175..1.177 rows=11 loops=1)
--     Filter: (date_start = CURRENT_DATE)
--     Rows Removed by Filter: 14989
--     Planning Time: 0.239 ms
--     Execution Time: 1.535 ms


-- Индекс на столбец date_start таблицы sessions:
CREATE INDEX idx_date_start ON sessions (date_start);

explain analyse SELECT f.name, s.date_start, s.time_start
FROM films f
         JOIN sessions s ON f.id = s.film_id
WHERE s.date_start = CURRENT_DATE;

-- Результат после приминения индексов:
-- Merge Join  (cost=27.15..32.00 rows=7 width=23) (actual time=0.165..0.388 rows=11 loops=1)
--     Merge Cond: (f.id = s.film_id)
--     ->  Index Scan using films_pkey on films f  (cost=0.28..45.27 rows=1000 width=15) (actual time=0.007..0.139 rows=101 loops=1)
--     ->  Sort  (cost=26.87..26.89 rows=7 width=16) (actual time=0.065..0.084 rows=11 loops=1)
--     Sort Key: s.film_id
--     Sort Method: quicksort  Memory: 25kB
--     ->  Bitmap Heap Scan on sessions s  (cost=4.34..26.78 rows=7 width=16) (actual time=0.019..0.047 rows=11 loops=1)
--     Recheck Cond: (date_start = CURRENT_DATE)
--     Heap Blocks: exact=10
--     ->  Bitmap Index Scan on idx_date_start  (cost=0.00..4.34 rows=7 width=0) (actual time=0.010..0.011 rows=11 loops=1)
--     Index Cond: (date_start = CURRENT_DATE)
--     Planning Time: 0.149 ms
--     Execution Time: 0.426 ms


-- Вывод: Индексы значительно повлияли на производительность запроса


