-- Выбор всех фильмов на сегодня

EXPLAIN SELECT
	m.title AS фильм
FROM
	seances s
INNER JOIN movies m 
ON
	m.movie_id = s.seance_id
WHERE s.start_time::date = CURRENT_DATE;

--QUERY PLAN                                                            |
------------------------------------------------------------------------+
--Hash Join  (cost=249.63..449.89 rows=50 width=11)                     |
--  Hash Cond: (m.movie_id = s.seance_id)                               |
--  ->  Seq Scan on movies m  (cost=0.00..174.00 rows=10000 width=15)   |
--  ->  Hash  (cost=249.00..249.00 rows=50 width=4)                     |
--        ->  Seq Scan on seances s  (cost=0.00..249.00 rows=50 width=4)|
--              Filter: ((start_time)::date = CURRENT_DATE)             |

-- Добавляем индекс
--
CREATE INDEX start_time_index ON seances (start_time);
--
--QUERY PLAN                                                            |
------------------------------------------------------------------------+
--Hash Join  (cost=249.63..449.89 rows=50 width=11)                     |
--  Hash Cond: (m.movie_id = s.seance_id)                               |
--  ->  Seq Scan on movies m  (cost=0.00..174.00 rows=10000 width=15)   |
--  ->  Hash  (cost=249.00..249.00 rows=50 width=4)                     |
--        ->  Seq Scan on seances s  (cost=0.00..249.00 rows=50 width=4)|
--              Filter: ((start_time)::date = CURRENT_DATE)             |
--
--Улучшений нет. Меняем структуру БД. Отдельно храним дату и время

-- Добавляем индекс

CREATE INDEX start_time_index ON seances (start_date);

EXPLAIN SELECT
	m.title AS фильм
FROM
	seances s
INNER JOIN movies m 
ON
	m.movie_id = s.seance_id
WHERE s.start_date = CURRENT_DATE;

--QUERY PLAN                                                                                 |
---------------------------------------------------------------------------------------------+
--Hash Join  (cost=94.15..294.41 rows=450 width=11)                                          |
--  Hash Cond: (m.movie_id = s.seance_id)                                                    |
--  ->  Seq Scan on movies m  (cost=0.00..174.00 rows=10000 width=15)                        |
--  ->  Hash  (cost=88.53..88.53 rows=450 width=4)                                           |
--        ->  Bitmap Heap Scan on seances s  (cost=7.78..88.53 rows=450 width=4)             |
--              Recheck Cond: (start_date = CURRENT_DATE)                                    |
--              ->  Bitmap Index Scan on start_time_index  (cost=0.00..7.66 rows=450 width=0)|
--                    Index Cond: (start_date = CURRENT_DATE)                                |
                    
                    