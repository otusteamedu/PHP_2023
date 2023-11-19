SELECT
    nspname || '.' || relname as name,
    pg_size_pretty(pg_total_relation_size(C.oid)) as totalsize,
    pg_size_pretty(pg_relation_size(C.oid)) as relsize
FROM pg_class C
LEFT JOIN pg_namespace N ON (N.oid = c.relnamespace)
WHERE nspname NOT IN ('pg_catalog', 'information_schema')
ORDER BY pg_total_relation_size(C.oid) DESC
LIMIT 15;

-- name                  | totalsize |  relsize
-- ----------------------------------------+-----------+------------
--  public.movies                          | 1398 MB   | 1115 MB
--  public.tickets                         | 1007 MB   | 651 MB
--  public.sessions                        | 945 MB    | 730 MB
--  public.tickets_pkey                    | 214 MB    | 214 MB
--  public.movies_pkey                     | 214 MB    | 214 MB
--  public.sessions_pkey                   | 214 MB    | 214 MB
--  public.tickets_session_id_idx          | 78 MB     | 78 MB
--  public.movies_date_start_date_end_idx  | 68 MB     | 68 MB
--  public.tickets_status_purchased_at_idx | 63 MB     | 63 MB
--  pg_toast.pg_toast_2618                 | 528 kB    | 480 kB
--  pg_toast.pg_toast_2619                 | 72 kB     | 24 kB
--  public.seats                           | 24 kB     | 8192 bytes
--  public.cinema                          | 24 kB     | 8192 bytes
--  public.halls                           | 24 kB     | 8192 bytes
--  public.seats_pkey                      | 16 kB     | 16 kB
-- (15 rows)
