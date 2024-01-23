-- отсортированный список (15 значений) самых больших по размеру объектов БД (таблицы, включая индексы, сами индексы)
SELECT nspname || '.' || relname AS object_name, pg_size_pretty(pg_total_relation_size(C.oid)) AS total_size
FROM pg_class C
     LEFT JOIN pg_namespace N ON (N.oid = C.relnamespace)
WHERE nspname = current_schema()
  AND relkind IN ('r', 'i')
ORDER BY pg_total_relation_size(C.oid) DESC
LIMIT 15;

-- часто используемые индексы
SELECT relname AS index_name, pg_stat_user_indexes.idx_scan AS total_scans
FROM pg_stat_user_indexes
     JOIN pg_index ON pg_index.indexrelid = pg_stat_user_indexes.indexrelid
ORDER BY pg_stat_user_indexes.idx_scan DESC
LIMIT 5;

-- редко используемые индексы:
SELECT relname AS index_name, pg_stat_user_indexes.idx_scan AS total_scans
FROM pg_stat_user_indexes
     JOIN pg_index ON pg_index.indexrelid = pg_stat_user_indexes.indexrelid
ORDER BY pg_stat_user_indexes.idx_scan ASC
LIMIT 5;
