-- 1. Check settings
SELECT name, setting FROM pg_settings;

--2. Tables & Indexes size stat
SELECT
    relname AS entity,
    CASE
        WHEN relkind = 'r' OR relkind = 't' THEN 'table'
        WHEN relkind = 'i' THEN 'index'
        WHEN relkind = 'm' THEN 'materialized view'
        END type,
    relnatts AS fields,
    pg_size_pretty(pg_table_size(C.oid)) AS size,
    pg_size_pretty(pg_indexes_size(C.oid)) AS index_size,
    pg_size_pretty(pg_total_relation_size(C.oid)) AS total,
    to_char(reltuples, '999 999 999 999') AS rows,
    relfilenode AS filename
FROM
    pg_class C
    LEFT JOIN pg_namespace N ON (N.oid = C.relnamespace)
WHERE
    nspname NOT IN ('pg_catalog', 'information_schema') AND
    nspname !~ '^pg_toast' AND
    relkind IN ('r', 't', 'i', 'm')
ORDER BY
    pg_total_relation_size(C.oid) DESC
LIMIT 50;

--2. Indexes usage stat
SELECT
    table_name,
    pg_size_pretty(table_size) AS table_size,
    index_name,
    pg_size_pretty(index_size) AS index_size,
    pg_size_pretty(total_indexes_size) AS indexes_size,
    idx_scan AS index_scans
FROM (
    SELECT (CASE
            WHEN schemaname = 'public'
                THEN format('%I', p.relname)
            ELSE
                format('%I.%I', schemaname, p.relname) END
        ) AS table_name,
        indexrelname AS index_name,
        pg_relation_size(p.relid) AS table_size,
        pg_relation_size(p.indexrelid) AS index_size,
        pg_indexes_size(p.relid) AS total_indexes_size,
        idx_scan
    FROM
        (SELECT * FROM pg_stat_user_indexes) p
            JOIN pg_class c ON p.indexrelid = c.oid
            JOIN pg_index i ON i.indexrelid = p.indexrelid
        where pg_get_indexdef(p.indexrelid) LIKE '%USING btree%'
            AND i.indisvalid
            AND (c.relpersistence = 'p' OR NOT pg_is_in_recovery())
    ORDER BY table_size DESC, index_size DESC
) t
LIMIT 50;
