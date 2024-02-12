select
    nspname || '.' || relname                     AS "relation",
    pg_size_pretty(pg_total_relation_size(C.oid)) AS "total_size",
    pg_size_pretty(pg_relation_size(C.oid))       AS "relation_size"
FROM pg_class C
         LEFT JOIN pg_namespace N ON (N.oid = C.relnamespace)
WHERE nspname NOT IN ('pg_catalog', 'information_schema')
ORDER BY pg_total_relation_size(C.oid) DESC LIMIT 15;

/*
|relation                          |total_size|relation_size|
|----------------------------------|----------|-------------|
|public.ticket                     |965 MB    |549 MB       |
|public.demonstration              |712 MB    |498 MB       |
|public.ticket_id_idx              |214 MB    |214 MB       |
|public.demonstration_id_idx       |214 MB    |214 MB       |
|public.ticket_demonstration_id_idx|69 MB     |69 MB        |
|public.ticket_position_id_idx     |66 MB     |66 MB        |
|public.ticket_status_id_idx       |66 MB     |66 MB        |
|pg_toast.pg_toast_2618            |560 kB    |512 kB       |
|pg_toast.pg_toast_2619            |72 kB     |24 kB        |
|pg_toast.pg_toast_1255            |56 kB     |8192 bytes   |
|public.dict_hall                  |48 kB     |8192 bytes   |
|public.dict_session               |48 kB     |8192 bytes   |
|public.location                   |32 kB     |8192 bytes   |
|public.film                       |32 kB     |8192 bytes   |
|public.seating_position           |32 kB     |8192 bytes   |
*/

