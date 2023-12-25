-- Выбор всех фильмов на сегодня
SELECT 
    films.name as name, halls.name as hall, to_char(sessions.start_at, 'HH24:MI')
FROM sessions
LEFT JOIN films ON films.id = sessions.film_id
LEFT JOIN halls ON halls.id = sessions.hall_id
WHERE DATE(sessions.start_at) = current_date
ORDER BY sessions.start_at;

-- Подсчёт проданных билетов за неделю
SELECT COUNT(*) FROM 
    orders
WHERE 
    DATE(created_at) >= DATE( CURRENT_TIMESTAMP - '7 days'::interval ) 
    and DATE(created_at) < CURRENT_DATE 
    and status = 'purchased';

    SELECT COUNT(*) FROM 
    orders
WHERE 
    DATE(created_at) >= DATE( CURRENT_TIMESTAMP - '7 days'::interval ) 
    and DATE(created_at) < CURRENT_DATE 
    and status = 'purchased';

-- Формирование афиши (фильмы, которые показывают сегодня)   
SELECT 
    films.name as name, halls.name as hall, to_char(sessions.start_at, 'HH24:MI')
FROM Sessions
LEFT JOIN films ON films.id = sessions.film_id
LEFT JOIN halls ON halls.id = sessions.hall_id
WHERE 
    DATE(sessions.start_at) = CURRENT_DATE
    AND sessions.start_at > CURRENT_TIMESTAMP
ORDER BY sessions.start_at;

-- Поиск 3 самых прибыльных фильмов за неделю
SELECT 
	films.name, max(orders.price) as total 
FROM 
    orders
LEFT JOIN sessions ON sessions.id = orders.session_id	
LEFT JOIN films ON films.id = sessions.film_id	
WHERE 
    DATE(created_at) >= DATE( CURRENT_TIMESTAMP - '7 days'::interval ) 
    and DATE(created_at) < CURRENT_DATE 
    and status = 'purchased'
GROUP BY films.id
ORDER BY total DESC LIMIT 3;


-- Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс

SELECT orders.session_id, COUNT(orders.session_id) as c FROM orders GROUP BY orders.session_id ORDER BY c DESC LIMIT 1;

WITH s as (
    SELECT * FROM 
        sessions
    WHERE sessions.id = 11667
)
SELECT places.row_id as row, places.number, orders.status FROM s
    RIGHT JOIN rows ON rows.hall_id = s.hall_id
    RIGHT JOIN places ON places.row_id = rows.id
    LEFT JOIN orders ON orders.place_id = places.id AND orders.session_id = s.id
WHERE rows.hall_id = s.hall_id
ORDER BY row, number;


--Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс
WITH s as (
    SELECT * FROM 
        sessions
    WHERE sessions.id = 2879
)
SELECT max(SessionPrices.price), min(SessionPrices.price) FROM s
    RIGHT JOIN rows ON rows.hall_id = s.hall_id
    RIGHT JOIN places ON places.row_id = rows.id
    LEFT JOIN orders ON orders.place_id = places.id AND orders.session_id = s.id
    LEFT JOIN SessionPrices ON SessionPrices.type_id = rows.type_id AND SessionPrices.session_id = s.id
WHERE rows.hall_id = s.hall_id;

-- отсортированный список (15 значений) самых больших по размеру объектов БД
SELECT nspname || '.' || relname as name,
      pg_size_pretty(pg_total_relation_size(C.oid)) as totalsize,
      pg_size_pretty(pg_relation_size(C.oid)) as relsize
FROM pg_class C
LEFT JOIN pg_namespace N ON (N.oid = C.relnamespace)
WHERE nspname NOT IN ('pg_catalog', 'information_schema')
ORDER BY pg_total_relation_size(C.oid) DESC
LIMIT 15;

-- Список используемых индексов
SELECT
    idstat.relname AS TABLE_NAME, -- имя таблицы
    indexrelname AS index_name, -- индекс
    idstat.idx_scan AS index_scans_count, -- число сканирований по этому индексу
    pg_size_pretty(pg_relation_size(indexrelid)) AS index_size, -- размер индекса
    tabstat.idx_scan AS table_reads_index_count, -- индексных чтений по таблице
    tabstat.seq_scan AS table_reads_seq_count, -- последовательных чтений по таблице
    tabstat.seq_scan + tabstat.idx_scan AS table_reads_count, -- чтений по таблице
    n_tup_upd + n_tup_ins + n_tup_del AS table_writes_count, -- операций записи
    pg_size_pretty(pg_relation_size(idstat.relid)) AS table_size -- размер таблицы
FROM
    pg_stat_user_indexes AS idstat
JOIN
    pg_indexes
    ON
    indexrelname = indexname
    AND
    idstat.schemaname = pg_indexes.schemaname
JOIN
    pg_stat_user_tables AS tabstat
    ON
    idstat.relid = tabstat.relid
WHERE
    indexdef !~* 'unique'
ORDER BY
    idstat.idx_scan DESC,
    pg_relation_size(indexrelid) DESC;   
