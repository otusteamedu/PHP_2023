--Выбор фильмов на сегодня

explain analyse
SELECT DISTINCT films.name
FROM
    sessions LEFT JOIN films ON films.id = sessions.film_id
WHERE
    sessions.datetime BETWEEN current_date::timestamp AND concat(CURRENT_DATE, ' 23:59:59')::timestamp;

-- Unique  (cost=187.82..187.92 rows=21 width=27) (actual time=2.619..2.807 rows=20 loops=1)
--   ->  Sort  (cost=187.82..187.87 rows=21 width=27) (actual time=2.612..2.688 rows=20 loops=1)
--         Sort Key: films.name
--         Sort Method: quicksort  Memory: 25kB
--         ->  Nested Loop Left Join  (cost=0.29..187.35 rows=21 width=27) (actual time=0.070..2.504 rows=20 loops=1)
--               ->  Seq Scan on sessions  (cost=0.00..37.00 rows=21 width=4) (actual time=0.041..2.102 rows=20 loops=1)
-- "                    Filter: ((datetime >= (CURRENT_DATE)::timestamp without time zone) AND (datetime <= (concat(CURRENT_DATE, ' 23:59:59'))::timestamp without time zone))"
--                     Rows Removed by Filter: 980
--               ->  Index Scan using films_pk on films  (cost=0.29..7.16 rows=1 width=31) (actual time=0.011..0.011 rows=1 loops=20)
--                     Index Cond: (id = sessions.film_id)
-- Planning Time: 0.461 ms
-- Execution Time: 2.908 ms

--Создал индекс в таблице sessions по полю datetime
create index idx_datetime on sessions(datetime);

-- Unique  (cost=162.95..163.06 rows=21 width=27) (actual time=0.808..1.019 rows=20 loops=1)
--   ->  Sort  (cost=162.95..163.00 rows=21 width=27) (actual time=0.797..0.878 rows=20 loops=1)
--         Sort Key: films.name
--         Sort Method: quicksort  Memory: 25kB
--         ->  Nested Loop Left Join  (cost=4.79..162.49 rows=21 width=27) (actual time=0.112..0.662 rows=20 loops=1)
--               ->  Bitmap Heap Scan on sessions  (cost=4.51..12.14 rows=21 width=4) (actual time=0.075..0.179 rows=20 loops=1)
-- "                    Recheck Cond: ((datetime >= (CURRENT_DATE)::timestamp without time zone) AND (datetime <= (concat(CURRENT_DATE, ' 23:59:59'))::timestamp without time zone))"
--                     Heap Blocks: exact=7
--                     ->  Bitmap Index Scan on idx_datetime  (cost=0.00..4.50 rows=21 width=0) (actual time=0.052..0.054 rows=20 loops=1)
-- "                          Index Cond: ((datetime >= (CURRENT_DATE)::timestamp without time zone) AND (datetime <= (concat(CURRENT_DATE, ' 23:59:59'))::timestamp without time zone))"
--               ->  Index Scan using films_pk on films  (cost=0.29..7.16 rows=1 width=31) (actual time=0.013..0.013 rows=1 loops=20)
--                     Index Cond: (id = sessions.film_id)
-- Planning Time: 0.734 ms
-- Execution Time: 1.209 ms
