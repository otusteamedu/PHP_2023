select
    nspname || '.' || relname                     AS "relation",
    pg_size_pretty(pg_total_relation_size(C.oid)) AS "total_size",
    pg_size_pretty(pg_relation_size(C.oid))       AS "relation_size"
FROM pg_class C
LEFT JOIN pg_namespace N ON (N.oid = C.relnamespace)
WHERE nspname NOT IN ('pg_catalog', 'information_schema')
ORDER BY pg_total_relation_size(C.oid) DESC LIMIT 15;
/*
|relation                    |total_size|relation_size|
|----------------------------|----------|-------------|
|public.ticket               |1001 MB   |1000 MB      |
|public.demonstration        |712 MB    |498 MB       |
|public.demonstration_id_idx |214 MB    |214 MB       |
|public.film                 |1224 kB   |1184 kB      |
|pg_toast.pg_toast_2618      |576 kB    |528 kB       |
|public.seating_position     |80 kB     |32 kB        |
|pg_toast.pg_toast_2619      |72 kB     |24 kB        |
|pg_toast.pg_toast_1255      |56 kB     |8192 bytes   |
|public.dict_session         |48 kB     |8192 bytes   |
|public.dict_status          |48 kB     |8192 bytes   |
|public.dict_ui_color        |48 kB     |8192 bytes   |
|public.location             |48 kB     |16 kB        |
|public.dict_hall            |48 kB     |8192 bytes   |
|pg_toast.pg_toast_1255_index|16 kB     |16 kB        |
|pg_toast.pg_toast_2619_index|16 kB     |16 kB        |
*/
