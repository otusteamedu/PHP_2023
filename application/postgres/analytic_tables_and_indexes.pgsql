SELECT nspname || '.' || relname                     AS "relation",
       pg_size_pretty(pg_total_relation_size(C.oid)) AS "total_size",
       pg_size_pretty(pg_relation_size(C.oid))       AS "relation_size"
FROM pg_class C
         LEFT JOIN pg_namespace N ON (N.oid = C.relnamespace)
WHERE nspname NOT IN ('pg_catalog', 'information_schema')
ORDER BY pg_total_relation_size(C.oid) DESC LIMIT 15;

/**
  Данные на 1М записей

mydb=# SELECT nspname || '.' || relname                     AS "relation",
   pg_size_pretty(pg_total_relation_size(C.oid)) AS "total_size",
   pg_size_pretty(pg_relation_size(C.oid))       AS "relation_size"
FROM pg_class C
         LEFT JOIN pg_namespace N ON (N.oid = C.relnamespace)
WHERE nspname NOT IN ('pg_catalog', 'information_schema')
ORDER BY pg_total_relation_size(C.oid) DESC LIMIT 15;
            relation            | total_size | relation_size
--------------------------------+------------+---------------
 public.films                   | 104 MB     | 83 MB
 public.film_type_to_films      | 102 MB     | 59 MB
 public.screenings              | 101 MB     | 73 MB
 public.visitors                | 88 MB      | 57 MB
 public.tickets                 | 85 MB      | 57 MB
 public.film_genres             | 71 MB      | 50 MB
 public.film_type_to_films_pkey | 43 MB      | 43 MB
 public.film_genres_pkey        | 21 MB      | 21 MB
 public.screenings_pkey         | 21 MB      | 21 MB
 public.tickets_pkey            | 21 MB      | 21 MB
 public.visitors_pkey           | 21 MB      | 21 MB
 public.films_pkey              | 21 MB      | 21 MB
 public.visitors_screening_id   | 9144 kB    | 9144 kB
 public.screenings_start_date   | 6504 kB    | 6504 kB
 public.tickets_created_at      | 6496 kB    | 6496 kB
(15 rows)
 */