-- Простые запросы

-- 1. Выбор билетов стоимостью > 350
SELECT * FROM tickets WHERE total_price > 350;

-- 2. Выбор билетов по id сеанса
SELECT * FROM tickets WHERE session_id = 9;

-- 3. Вывод мин. и макс. цены за билет на конкретный сеанс
SELECT MIN(total_price) AS min_price, MAX(total_price) AS max_price FROM tickets WHERE session_id = 9;

-- Сложные запросы

-- 4. Вывод названий фильмов, показанных в определенную дату, на которые были куплены билеты
SELECT f.name FROM films AS f JOIN sessions AS s ON s.film_id=f.id JOIN tickets AS t ON t.session_id=s.id WHERE t.payed=true AND s.date_start BETWEEN '2023-03-01 00:00:00' AND '2023-03-01 23:59:59' GROUP BY f.id;

-- 5. Поиск 3 самых прибыльных фильмов за неделю
SELECT f.name, SUM(t.total_price) AS sum FROM films AS f JOIN sessions AS s ON s.film_id=f.id JOIN tickets AS t ON t.session_id=s.id WHERE t.payed=true AND s.date_start BETWEEN '2023-03-01 00:00:00' AND '2023-03-06 23:59:59' GROUP BY f.id ORDER BY sum DESC LIMIT 3;

-- 6. Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
SELECT r.number AS row_number, p.number AS place_number, t.payed AS is_taken FROM places AS p JOIN rows AS r ON r.id=p.row_id JOIN sessions AS s ON r.hall_id=s.hall_id JOIN tickets AS t ON t.row_id=r.id AND t.place_id=p.id AND t.session_id=s.id WHERE s.id=9;

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
