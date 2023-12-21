--Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
EXPLAIN
ANALYSE
SELECT sih.row,
       sih.seats,
       CASE WHEN t.id is NOT NULL THEN 1 ELSE 0 END AS busy
from seats_in_halls as sih
         LEFT JOIN tickets as t on t.seat_in_hall_id = sih.id
where sih.hall_id = 1
    and t.showtime_id = 1
   or t.id is null;
-- Hash Right Join  (cost=55.90..233.08 rows=45 width=8) (actual time=0.863..4.669 rows=9 loops=1)
-- Planning Time: 0.484 ms
-- Execution Time: 4.805 ms

create index idx_sessions_datetime on showtime (start_time);
-- Hash Right Join  (cost=55.90..233.08 rows=45 width=8) (actual time=3.831..7.190 rows=9 loops=1)
-- Planning Time: 0.209 ms
-- Execution Time: 7.326 ms

-- Запрос после создания индекса
EXPLAIN
ANALYSE
SELECT sih.row,
       sih.seats,
       CASE WHEN t.id is NOT NULL THEN 1 ELSE 0 END AS busy
from seats_in_halls as sih
         LEFT JOIN tickets as t on t.seat_in_hall_id = sih.id
where sih.hall_id = 1
    and t.showtime_id = 1
   or t.id is null;
-- Hash Right Join  (cost=55.90..233.08 rows=45 width=8) (actual time=0.421..1.562 rows=9 loops=1)
-- Planning Time: 0.095 ms
-- Execution Time: 1.005 ms

-- Вывод: Индексы значительно повлияли на производительность запроса