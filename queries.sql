-- 1. Выбор всех фильмов на сегодня

SELECT title FROM movie;

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


EXPLAIN ANALYSE
SELECT t.screening_id,
       MAX(s.price) AS max_price,
       MIN(s.price) AS min_price
FROM ticket t
         INNER JOIN screening s on s.id = t.screening_id
GROUP BY t.screening_id;


EXPLAIN ANALYSE
SELECT s.price
FROM screening s
         INNER JOIN ticket t on s.id = t.screening_id;

select pg_reload_conf();
