-- 1. Выбор всех фильмов на сегодня

-- SELECT title FROM movie;

SELECT m.title AS movie_title
FROM movie m
         INNER JOIN movie_attr_value mav_start ON m.ID = mav_start.movie_id
         INNER JOIN movie_attr ma_start ON mav_start.movie_attr_id = ma_start.ID AND ma_start.name = 'russia_show_start_date'
         INNER JOIN movie_attr_type mat_start ON ma_start.movie_attr_type_id = mat_start.ID AND mat_start.name = 'date'
         INNER JOIN movie_attr_value mav_end ON m.ID = mav_end.movie_id
         INNER JOIN movie_attr ma_end ON mav_end.movie_attr_id = ma_end.ID AND ma_end.name = 'russia_show_end_date'
         INNER JOIN movie_attr_type mat_end ON ma_end.movie_attr_type_id = mat_end.ID AND mat_end.name = 'date'
WHERE current_date BETWEEN mav_start.val_date AND mav_end.val_date;

-- 2. Подсчёт проданных билетов за неделю

SELECT m.title         AS movie_title,
       count(movie_id) AS tickets_sold_out_count
FROM movie m
         INNER JOIN ticket t ON m.ID = t.movie_id
         INNER JOIN screening s ON t.screening_id = s.id
WHERE t.sale_date BETWEEN current_date - 7 AND current_date
GROUP BY m.ID
ORDER BY count(movie_id) DESC;

-- 3. Формирование афиши (фильмы, которые показывают сегодня)

SELECT m.title            AS movie_title,
       mav_start.val_date AS russia_show_start_date,
       mav_end.val_date   AS russia_show_end_date
FROM movie m
         INNER JOIN movie_attr_value mav_start ON m.ID = mav_start.movie_id
         INNER JOIN movie_attr ma_start ON mav_start.movie_attr_id = ma_start.ID AND ma_start.name = 'russia_show_start_date'
         INNER JOIN movie_attr_type mat_start ON ma_start.movie_attr_type_id = mat_start.ID AND mat_start.name = 'date'
         INNER JOIN movie_attr_value mav_end ON m.ID = mav_end.movie_id
         INNER JOIN movie_attr ma_end ON mav_end.movie_attr_id = ma_end.ID AND ma_end.name = 'russia_show_end_date'
         INNER JOIN movie_attr_type mat_end ON ma_end.movie_attr_type_id = mat_end.ID AND mat_end.name = 'date'
WHERE current_date BETWEEN mav_start.val_date AND mav_end.val_date;

-- 4. Поиск 3 самых прибыльных фильмов за неделю

SELECT m.title      AS movie_title,
       sum(s.price) AS movie_sum_profit
FROM movie m
         INNER JOIN ticket t on m.ID = t.movie_id
         INNER JOIN screening s on t.screening_id = s.id
WHERE t.sale_date BETWEEN current_date - 7 AND current_date
GROUP BY m.ID
ORDER BY sum(s.price) DESC;

-- 5. Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс

SELECT DISTINCT m.title,
                random_row AS row,
                random_seat AS seat,
                CASE
                    WHEN EXISTS(SELECT 1
                                FROM ticket
                                WHERE row = random_row
                                  AND seat = random_seat
                                  AND screening_id = 4  -- test value
                                  AND room_id = 5  -- test value
                                  AND movie_id = 2  -- test value
                                  AND show_date = '2023-09-11'  -- test value
                        )
                        THEN 'closed'
                    ELSE 'free'
                    END     AS status,
                t.show_date AS movie_show_date
FROM ticket t
         INNER JOIN movie m on m.id = t.movie_id
         INNER JOIN room r ON r.id = t.room_id,
     generate_series(1, r.rows_count) AS random_row,
     generate_series(1, r.seats_count / r.rows_count) AS random_seat
WHERE screening_id = 4 -- test value
  AND room_id = 5  -- test value
  AND t.movie_id = 2  -- test value
  AND t.show_date = '2023-06-11'  -- test value
ORDER BY random_row, random_seat;


-- 6. Вывести диапазон минимальной и максимальной цены за билет на конкретный сеанс

EXPLAIN ANALYSE
SELECT t.screening_id,
       MAX(s.price) AS max_price,
       MIN(s.price) AS min_price
FROM ticket t
         INNER JOIN screening s on s.id = t.screening_id
WHERE screening_id = 1           -- test value
  AND room_id = 5                -- test value
  AND t.movie_id = 2             -- test value
  AND t.show_date = '2023-06-11' -- test value
GROUP BY t.screening_id;

--  План 10000 строк

/*
GroupAggregate  (cost=0.15..347.50 rows=1 width=20) (actual time=2.901..2.902 rows=0 loops=1)
  Group Key: t.screening_id
  ->  Nested Loop  (cost=0.15..347.48 rows=1 width=12) (actual time=2.900..2.901 rows=0 loops=1)
        ->  Seq Scan on ticket t  (cost=0.00..339.30 rows=1 width=4) (actual time=2.899..2.899 rows=0 loops=1)
              Filter: ((screening_id = 1) AND (room_id = 5) AND (movie_id = 2) AND (show_date = '2023-06-11'::date))
              Rows Removed by Filter: 11754
        ->  Index Scan using screening_pkey on screening s  (cost=0.15..8.17 rows=1 width=12) (never executed)
              Index Cond: (id = 1)
Planning Time: 1.007 ms
Execution Time: 3.094 ms
*/

--  План 100000 строк до оптимизации

/*
GroupAggregate  (cost=1000.15..9144.79 rows=1 width=20) (actual time=107.418..113.938 rows=0 loops=1)
  Group Key: t.screening_id
  ->  Nested Loop  (cost=1000.15..9144.77 rows=1 width=12) (actual time=107.416..113.936 rows=0 loops=1)
        ->  Gather  (cost=1000.00..9136.59 rows=1 width=4) (actual time=107.415..113.934 rows=0 loops=1)
              Workers Planned: 2
              Workers Launched: 2
              ->  Parallel Seq Scan on ticket t  (cost=0.00..8136.49 rows=1 width=4) (actual time=36.318..36.318 rows=0 loops=3)
                    Filter: ((screening_id = 1) AND (room_id = 5) AND (movie_id = 2) AND (show_date = '2023-06-11'::date))
                    Rows Removed by Filter: 172900
        ->  Index Scan using screening_pkey on screening s  (cost=0.15..8.17 rows=1 width=12) (never executed)
              Index Cond: (id = 1)
Planning Time: 3.746 ms
Execution Time: 114.056 ms
*/

--  План 100000 строк после оптимизации

/*
GroupAggregate  (cost=0.58..4.70 rows=13 width=20) (actual time=0.992..0.993 rows=1 loops=1)
  Group Key: t.screening_id
  ->  Nested Loop  (cost=0.58..4.40 rows=23 width=12) (actual time=0.926..0.935 rows=20 loops=1)
        ->  Index Scan using screening_pkey on screening s  (cost=0.15..2.17 rows=1 width=12) (actual time=0.017..0.018 rows=1 loops=1)
              Index Cond: (id = 1)
        ->  Index Only Scan using idx_screening_movie on ticket t  (cost=0.42..2.00 rows=23 width=4) (actual time=0.904..0.909 rows=20 loops=1)
              Index Cond: ((show_date = '2023-06-11'::date) AND (movie_id = 2) AND (screening_id = 1) AND (room_id = 5))
              Heap Fetches: 0
Planning Time: 3.378 ms
Execution Time: 1.065 ms
*/

-- Оптимизация

/*
CREATE UNIQUE INDEX idx_screening_movie ON ticket (show_date, movie_id, screening_id, room_id, seat, row);
random_page_cost = 1.0  - уменьшил стоимость случайного чтения чтобы планировщик охотнее использовал индекс + у меня быстрый SSD
*/


EXPLAIN ANALYSE
SELECT t.screening_id,
       MAX(s.price) AS max_price,
       MIN(s.price) AS min_price
FROM ticket t
         INNER JOIN screening s on s.id = t.screening_id
GROUP BY t.screening_id;

--  План 10000 строк

/*
HashAggregate  (cost=332.20..332.38 rows=18 width=20) (actual time=7.005..7.012 rows=18 loops=1)
  Group Key: t.screening_id
  Batches: 1  Memory Usage: 24kB
  ->  Hash Join  (cost=1.41..244.05 rows=11753 width=12) (actual time=0.047..4.287 rows=11753 loops=1)
        Hash Cond: (t.screening_id = s.id)
        ->  Seq Scan on ticket t  (cost=0.00..204.53 rows=11753 width=4) (actual time=0.009..1.219 rows=11753 loops=1)
        ->  Hash  (cost=1.18..1.18 rows=18 width=12) (actual time=0.022..0.024 rows=18 loops=1)
              Buckets: 1024  Batches: 1  Memory Usage: 9kB
              ->  Seq Scan on screening s  (cost=0.00..1.18 rows=18 width=12) (actual time=0.005..0.008 rows=18 loops=1)
Planning Time: 0.355 ms
Execution Time: 7.140 ms
*/

--  План 100000 строк до оптимизации

/*
Finalize GroupAggregate  (cost=20215.59..20220.24 rows=18 width=20) (actual time=236.640..245.451 rows=18 loops=1)
  Group Key: t.screening_id
  ->  Gather Merge  (cost=20215.59..20219.79 rows=36 width=20) (actual time=236.631..245.409 rows=54 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  Sort  (cost=19215.57..19215.61 rows=18 width=20) (actual time=185.211..185.215 rows=18 loops=3)
              Sort Key: t.screening_id
              Sort Method: quicksort  Memory: 26kB
              Worker 0:  Sort Method: quicksort  Memory: 26kB
              Worker 1:  Sort Method: quicksort  Memory: 26kB
              ->  Partial HashAggregate  (cost=19215.01..19215.19 rows=18 width=20) (actual time=185.125..185.131 rows=18 loops=3)
                    Group Key: t.screening_id
                    Batches: 1  Memory Usage: 24kB
                    Worker 0:  Batches: 1  Memory Usage: 24kB
                    Worker 1:  Batches: 1  Memory Usage: 24kB
                    ->  Hash Join  (cost=1.41..15991.42 rows=429812 width=12) (actual time=0.889..124.828 rows=343849 loops=3)
                          Hash Cond: (t.screening_id = s.id)
                          ->  Parallel Seq Scan on ticket t  (cost=0.00..14596.12 rows=429812 width=4) (actual time=0.041..47.909 rows=343849 loops=3)
                          ->  Hash  (cost=1.18..1.18 rows=18 width=12) (actual time=0.778..0.779 rows=18 loops=3)
                                Buckets: 1024  Batches: 1  Memory Usage: 9kB
                                ->  Seq Scan on screening s  (cost=0.00..1.18 rows=18 width=12) (actual time=0.733..0.736 rows=18 loops=3)
Planning Time: 0.405 ms
Execution Time: 245.641 ms
*/

--  План 100000 строк после оптимизации

/*
Finalize GroupAggregate  (cost=13939.56..13946.54 rows=18 width=20) (actual time=139.582..144.226 rows=18 loops=1)
  Group Key: t.screening_id
  ->  Gather Merge  (cost=13939.56..13945.95 rows=54 width=20) (actual time=139.576..144.212 rows=66 loops=1)
        Workers Planned: 3
        Workers Launched: 3
        ->  Sort  (cost=12939.52..12939.57 rows=18 width=20) (actual time=97.323..97.326 rows=16 loops=4)
              Sort Key: t.screening_id
              Sort Method: quicksort  Memory: 26kB
              Worker 0:  Sort Method: quicksort  Memory: 26kB
              Worker 1:  Sort Method: quicksort  Memory: 26kB
              Worker 2:  Sort Method: quicksort  Memory: 26kB
              ->  Partial HashAggregate  (cost=12938.97..12939.15 rows=18 width=20) (actual time=97.283..97.286 rows=16 loops=4)
                    Group Key: t.screening_id
                    Batches: 1  Memory Usage: 24kB
                    Worker 0:  Batches: 1  Memory Usage: 24kB
                    Worker 1:  Batches: 1  Memory Usage: 24kB
                    Worker 2:  Batches: 1  Memory Usage: 24kB
                    ->  Hash Join  (cost=1.83..10443.29 rows=332757 width=12) (actual time=1.660..63.984 rows=257887 loops=4)
                          Hash Cond: (t.screening_id = s.id)
                          ->  Parallel Index Only Scan using idx_screening_id on ticket t  (cost=0.42..9362.74 rows=332757 width=4) (actual time=0.751..24.576 rows=257887 loops=4)
                                Heap Fetches: 0
                          ->  Hash  (cost=1.18..1.18 rows=18 width=12) (actual time=0.871..0.872 rows=18 loops=4)
                                Buckets: 1024  Batches: 1  Memory Usage: 9kB
                                ->  Seq Scan on screening s  (cost=0.00..1.18 rows=18 width=12) (actual time=0.832..0.835 rows=18 loops=4)
Planning Time: 0.661 ms
Execution Time: 144.533 ms
*/

-- Оптимизация

/*
CREATE INDEX idx_screening_id ON ticket (screening_id);
max_parallel_workers_per_gather = 4  - улучшил асинхронную обработку операции Hash Join
*/


EXPLAIN ANALYSE
SELECT s.price
FROM screening s
         INNER JOIN ticket t on s.id = t.screening_id;

--  План 10000 строк

/*
Hash Join  (cost=1.41..244.05 rows=11753 width=8) (actual time=0.083..3.595 rows=11753 loops=1)
  Hash Cond: (t.screening_id = s.id)
  ->  Seq Scan on ticket t  (cost=0.00..204.53 rows=11753 width=4) (actual time=0.009..1.125 rows=11753 loops=1)
  ->  Hash  (cost=1.18..1.18 rows=18 width=12) (actual time=0.034..0.035 rows=18 loops=1)
        Buckets: 1024  Batches: 1  Memory Usage: 9kB
        ->  Seq Scan on screening s  (cost=0.00..1.18 rows=18 width=12) (actual time=0.007..0.010 rows=18 loops=1)
Planning Time: 0.370 ms
Execution Time: 4.158 ms
*/


--  План 100000 строк до оптимизации

/*
Hash Join  (cost=1.41..23960.25 rows=1031548 width=8) (actual time=0.148..321.375 rows=1031548 loops=1)
  Hash Cond: (t.screening_id = s.id)
  ->  Seq Scan on ticket t  (cost=0.00..20613.48 rows=1031548 width=4) (actual time=0.031..129.980 rows=1031548 loops=1)
  ->  Hash  (cost=1.18..1.18 rows=18 width=12) (actual time=0.038..0.040 rows=18 loops=1)
        Buckets: 1024  Batches: 1  Memory Usage: 9kB
        ->  Seq Scan on screening s  (cost=0.00..1.18 rows=18 width=12) (actual time=0.011..0.014 rows=18 loops=1)
Planning Time: 2.000 ms
Execution Time: 360.372 ms
*/

--  План 100000 строк после оптимизации

/*
Hash Join  (cost=1.83..22328.42 rows=1031548 width=8) (actual time=0.077..232.660 rows=1031548 loops=1)
  Hash Cond: (t.screening_id = s.id)
  ->  Index Only Scan using idx_screening_id on ticket t  (cost=0.42..18981.65 rows=1031548 width=4) (actual time=0.028..83.175 rows=1031548 loops=1)
        Heap Fetches: 0
  ->  Hash  (cost=1.18..1.18 rows=18 width=12) (actual time=0.032..0.035 rows=18 loops=1)
        Buckets: 1024  Batches: 1  Memory Usage: 9kB
        ->  Seq Scan on screening s  (cost=0.00..1.18 rows=18 width=12) (actual time=0.011..0.014 rows=18 loops=1)
Planning Time: 0.266 ms
Execution Time: 272.105 ms
*/

-- Оптимизация

/*
CREATE INDEX idx_screening_id ON ticket (screening_id);
random_page_cost = 1.0
Уменьшил стоимость случайного чтения чтобы планировщик охотнее использовал индекс + у меня быстрый SSD
*/

select pg_reload_conf();

-- 7. Отсортированный список (15 значений) самых больших по размеру объектов БД (таблицы, включая индексы, сами индексы)

SELECT nspname || '.' || relname                     as name,
       pg_size_pretty(pg_total_relation_size(C.oid)) as totalsize,
       pg_size_pretty(pg_relation_size(C.oid))       as realsize
FROM pg_class C
         LEFT JOIN pg_namespace N
                   ON (N.oid = C.relnamespace)
WHERE nspname NOT IN ('pg_catalog', 'information_schema')
ORDER BY pg_total_relation_size(C.oid) DESC
LIMIT 15;

-- 8. Отсортированные списки (по 5 значений) самых часто и редко используемых индексов

SELECT indexrelid::regclass AS index_name,
       relid::regclass      AS table_name,
       idx_scan             AS num_scans
FROM pg_stat_user_indexes
ORDER BY idx_scan DESC
LIMIT 5; -- 5 самых часто используемых индексов


SELECT indexrelid::regclass AS index_name,
       relid::regclass      AS table_name,
       idx_scan             AS num_scans
FROM pg_stat_user_indexes
WHERE idx_scan > 0
ORDER BY idx_scan
LIMIT 5; -- 5 самых редко используемых индексов
