-- Простые запросы

-- 1. Выбор всех фильмов на сегодня
SELECT DISTINCT film_id FROM tickets WHERE film_date_start BETWEEN '2023-03-01 00:00:00' AND '2023-03-01 23:59:59';

-- 2. Подсчёт проданных билетов за неделю
SELECT COUNT(1) AS payed_ticket_count FROM tickets WHERE payed = true AND purchase_date BETWEEN '2023-03-01 00:00:00' AND '2023-03-08 23:59:59';

-- 3. Вывести диапазон минимальной и максимальной цены за билет на конкретный сеанс
SELECT MIN(total_price) AS min_price, MAX(total_price) AS max_price FROM tickets WHERE session_id = 9;

-- Сложные запросы

-- 4. Формирование афиши (фильмы, которые показывают сегодня)
SELECT h.number AS hall_number, f.name AS film_name, s.date_start::time, s.date_end::time FROM sessions AS s
    JOIN films AS f ON s.film_id=f.id
    JOIN halls AS h ON s.hall_id=h.id
WHERE s.id IN (SELECT DISTINCT session_id FROM tickets AS t WHERE t.film_date_start BETWEEN '2023-03-01 00:00:00' AND '2023-03-01 23:59:59')
ORDER BY s.date_start::time;

-- 5. Поиск 3 самых прибыльных фильмов за неделю
-- первоначальный
SELECT f.name, SUM(t.total_price) AS sum FROM films AS f JOIN tickets AS t ON t.film_id=f.id WHERE (t.payed=true) AND (t.film_date_start BETWEEN '2023-03-01 00:00:00' AND '2023-03-08 23:59:59') GROUP BY f.id ORDER BY sum DESC LIMIT 3;
-- после оптимизации
SELECT f.name, SUM(t.total_price) AS sum FROM tickets AS t JOIN films AS f ON t.film_id=f.id WHERE (t.payed=true) AND (t.session_id IN (SELECT DISTINCT s.id FROM sessions AS s WHERE s.date_start BETWEEN '2023-03-01 00:00:00' AND '2023-03-08 23:59:59')) GROUP BY f.id ORDER BY sum DESC LIMIT 3;

-- 6. Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
SELECT (SELECT h.number FROM halls AS h WHERE h.id = (SELECT s.hall_id FROM sessions AS s WHERE s.id=9)) AS hall_number, r.number AS row_number, p.number AS place_number, t.payed AS is_taken FROM tickets AS t JOIN places AS p ON t.place_id=p.id JOIN rows AS r ON t.row_id=r.id WHERE t.session_id=9;

-- Отсортированные списки

-- Список (15 значений) самых больших по размеру объектов БД (таблицы, включая индексы, сами индексы)
WITH sizes AS
         (
             SELECT c.relname AS name, 'is_table' AS type, pg_total_relation_size('public.' || c.relname) AS size FROM pg_class AS c JOIN pg_tables AS t ON c.relname=t.tablename WHERE c.relkind='r' AND t.schemaname='public'
             UNION ALL
             SELECT c.relname AS name, 'is_index' AS type, pg_total_relation_size('public.' || c.relname) AS size FROM pg_class AS c JOIN pg_stat_all_indexes AS psai ON c.oid=psai.indexrelid WHERE c.relkind='i' AND psai.schemaname='public'
         )
SELECT name, type, size FROM sizes ORDER BY size DESC LIMIT 15;

--Список (5 значений) самых часто используемых индексов
SELECT relname AS table_name, indexrelname AS index_name, idx_scan AS use_count FROM pg_stat_all_indexes WHERE schemaname='public' ORDER BY idx_scan DESC LIMIT 5;

--Список (5 значений) самых редко используемых индексов
SELECT relname AS table_name, indexrelname AS index_name, idx_scan AS use_count FROM pg_stat_all_indexes WHERE schemaname='public' ORDER BY idx_scan LIMIT 5;
