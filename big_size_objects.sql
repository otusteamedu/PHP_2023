SELECT nspname || '.' || relname as name,
      pg_size_pretty(pg_total_relation_size(C.oid)) as totalsize,
      pg_size_pretty(pg_relation_size(C.oid)) as relsize
FROM pg_class C
LEFT JOIN pg_namespace N ON (N.oid = C.relnamespace)
WHERE nspname NOT IN ('pg_catalog', 'information_schema')
ORDER BY pg_total_relation_size(C.oid) DESC
LIMIT 15;


/**
name                     |totalsize|relsize   |
-------------------------+---------+----------+
public.tickets           |20 MB    |13 MB     |
public.tickets_pkey      |5128 kB  |5128 kB   |
public.status_idx        |1608 kB  |1608 kB   |
pg_toast.pg_toast_2618   |624 kB   |576 kB    |
public.seances           |264 kB   |88 kB     |
pg_toast.pg_toast_2619   |96 kB    |48 kB     |
public.rec               |64 kB    |64 kB     |
pg_toast.pg_toast_1255   |56 kB    |8192 bytes|
public.seances_pkey      |48 kB    |48 kB     |
public.seance_film_id_idx|32 kB    |32 kB     |
public.films             |32 kB    |8192 bytes|
public.start_at_idx      |32 kB    |32 kB     |
public.film_id_idx       |32 kB    |32 kB     |
public.halls             |24 kB    |8192 bytes|
public.genres            |24 kB    |8192 bytes|
*/