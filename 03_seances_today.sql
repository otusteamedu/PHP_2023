-- Формирование афиши (фильмы, которые показывают сегодня)

EXPLAIN SELECT
	h.title AS "Зал",
	m.title AS "Название фильма",
	s.start_time AS "Время начала"
FROM
	seances s
INNER JOIN halls h 
ON
	s.hall_id = h.hall_id
INNER JOIN movies m 
ON
	s.movie_id = m.movie_id
WHERE
	start_date = CURRENT_DATE;
	
--QUERY PLAN                                                                          |
--------------------------------------------------------------------------------------+
--Hash Join  (cost=515.69..806.53 rows=434 width=30)                                  |
--  Hash Cond: (m.movie_id = s.movie_id)                                              |
--  ->  Seq Scan on movies m  (cost=0.00..174.00 rows=10000 width=15)                 |
--  ->  Hash  (cost=510.26..510.26 rows=434 width=23)                                 |
--        ->  Hash Join  (cost=229.43..510.26 rows=434 width=23)                      |
--              Hash Cond: (h.hall_id = s.hall_id)                                    |
--              ->  Seq Scan on halls h  (cost=0.00..164.00 rows=10000 width=15)      |
--              ->  Hash  (cost=224.00..224.00 rows=434 width=16)                     |
--                    ->  Seq Scan on seances s  (cost=0.00..224.00 rows=434 width=16)|
--                          Filter: (start_date = CURRENT_DATE)                       |


-- Добавляем индекс (был добавлен ранее, предыдщий запрос без него)
CREATE INDEX start_time_index ON seances (start_date);

--QUERY PLAN                                                                                             |
---------------------------------------------------------------------------------------------------------+
--Hash Join  (cost=379.85..670.69 rows=434 width=30)                                                     |
--  Hash Cond: (m.movie_id = s.movie_id)                                                                 |
--  ->  Seq Scan on movies m  (cost=0.00..174.00 rows=10000 width=15)                                    |
--  ->  Hash  (cost=374.43..374.43 rows=434 width=23)                                                    |
--        ->  Hash Join  (cost=93.59..374.43 rows=434 width=23)                                          |
--              Hash Cond: (h.hall_id = s.hall_id)                                                       |
--              ->  Seq Scan on halls h  (cost=0.00..164.00 rows=10000 width=15)                         |
--              ->  Hash  (cost=88.16..88.16 rows=434 width=16)                                          |
--                    ->  Bitmap Heap Scan on seances s  (cost=7.65..88.16 rows=434 width=16)            |
--                          Recheck Cond: (start_date = CURRENT_DATE)                                    |
--                          ->  Bitmap Index Scan on start_time_index  (cost=0.00..7.54 rows=434 width=0)|
--                                Index Cond: (start_date = CURRENT_DATE)                                |
                                