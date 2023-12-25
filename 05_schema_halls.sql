-- Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс

EXPLAIN SELECT
	halls.title,
	seats.number_row,
	seats.seat_number,
	seances.start_time,
	seats.seat_id IN (SELECT seat_id FROM tickets WHERE tickets.seance_id = seances.seance_id) AS "Продан"
FROM
	seats
INNER JOIN halls
ON
	seats.hall_id = halls.hall_id
INNER  JOIN seances 
ON
	halls.hall_id = seances.hall_id
WHERE
	seances.seance_id = 2;
	
--QUERY PLAN                                                                                   |
-----------------------------------------------------------------------------------------------+
--Nested Loop  (cost=8.60..308.77 rows=1 width=28)                                             |
--  ->  Hash Join  (cost=8.31..208.59 rows=2 width=32)                                         |
--        Hash Cond: (seats.hall_id = seances.hall_id)                                         |
--        ->  Seq Scan on seats  (cost=0.00..174.00 rows=10000 width=16)                       |
--        ->  Hash  (cost=8.30..8.30 rows=1 width=16)                                          |
--              ->  Index Scan using seances_pkey on seances  (cost=0.29..8.30 rows=1 width=16)|
--                    Index Cond: (seance_id = 2)                                              |
--  ->  Index Scan using halls_pkey on halls  (cost=0.29..0.34 rows=1 width=15)                |
--        Index Cond: (hall_id = seats.hall_id)                                                |
--  SubPlan 1                                                                                  |
--    ->  Seq Scan on tickets  (cost=0.00..199.00 rows=2 width=4)                              |
--          Filter: (seance_id = seances.seance_id)                                            |
	
-- Добавляем индексы 
CREATE INDEX seance_id_index ON tickets (seance_id);
CREATE INDEX hall_id_seats_index ON seats (hall_id);
CREATE INDEX hall_id__seances_index ON seances (hall_id);

--QUERY PLAN                                                                             |
-----------------------------------------------------------------------------------------+
--Nested Loop  (cost=0.86..23.29 rows=1 width=28)                                        |
--  ->  Nested Loop  (cost=0.57..16.61 rows=1 width=31)                                  |
--        ->  Index Scan using seances_pkey on seances  (cost=0.29..8.30 rows=1 width=16)|
--              Index Cond: (seance_id = 2)                                              |
--        ->  Index Scan using halls_pkey on halls  (cost=0.29..8.30 rows=1 width=15)    |
--              Index Cond: (hall_id = seances.hall_id)                                  |
--  ->  Index Scan using hall_id_seats_index on seats  (cost=0.29..0.36 rows=2 width=16) |
--        Index Cond: (hall_id = halls.hall_id)                                          |
--  SubPlan 1                                                                            |
--    ->  Index Scan using seance_id_index on tickets  (cost=0.29..12.32 rows=2 width=4) |
--          Index Cond: (seance_id = seances.seance_id)                                  |
