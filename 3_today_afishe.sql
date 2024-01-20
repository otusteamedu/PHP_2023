select f.title, to_char(start_at, 'HH:MI') as time, h.title  from films f
join seances s ON s.film_id = f.id 
join halls h on h.id = s.hall_id  
where s.start_at::date = current_date 
order by time

/**
title                   |time |title|
------------------------+-----+-----+
Фильм 1                 |01:50|Зал 8|
Холоп 2                 |02:00|Зал 5|
Бременские музыканты    |02:00|Зал 3|
Холоп 2                 |03:15|Зал 4|
Бременские музыканты    |04:20|Зал 3|
Холоп 2                 |04:30|Зал 5|
Три богатыря и Пуп Земли|04:35|Зал 1|
Фильм 1                 |05:00|Зал 8|
Холоп 2                 |05:45|Зал 4|
Бременские музыканты    |06:40|Зал 3|
Холоп 2                 |07:00|Зал 5|
Фильм 1                 |07:10|Зал 8|
Три богатыря и Пуп Земли|07:30|Зал 1|
Холоп 2                 |08:15|Зал 4|
Бременские музыканты    |09:00|Зал 3|
Фильм 1                 |09:15|Зал 8|
Холоп 2                 |09:30|Зал 5|
Фильм 1                 |10:00|Зал 8|
Холоп 2                 |10:15|Зал 4|
Три богатыря и Пуп Земли|10:30|Зал 1|
Три богатыря и Пуп Земли|10:40|Зал 1|
Холоп 2                 |11:30|Зал 4|
Холоп 2                 |11:30|Зал 5|
Бременские музыканты    |11:40|Зал 3|
Фильм 1                 |11:45|Зал 8|
Три богатыря и Пуп Земли|12:10|Зал 1|
Холоп 2                 |12:45|Зал 4|
*/

QUERY PLAN                                                                                                                                  |
--------------------------------------------------------------------------------------------------------------------------------------------+
Sort  (cost=39.10..39.12 rows=7 width=1064) (actual time=0.304..0.314 rows=27 loops=1)                                                      |
  Sort Key: (to_char(s.start_at, 'HH:MI'::text))                                                                                            |
  Sort Method: quicksort  Memory: 26kB                                                                                                      |
  ->  Hash Join  (cost=25.93..39.01 rows=7 width=1064) (actual time=0.161..0.228 rows=27 loops=1)                                           |
        Hash Cond: (s.film_id = f.id)                                                                                                       |
        ->  Hash Join  (cost=15.25..28.30 rows=7 width=528) (actual time=0.104..0.126 rows=27 loops=1)                                      |
              Hash Cond: (h.id = s.hall_id)                                                                                                 |
              ->  Seq Scan on halls h  (cost=0.00..11.40 rows=140 width=520) (actual time=0.006..0.010 rows=8 loops=1)                      |
              ->  Hash  (cost=15.16..15.16 rows=7 width=16) (actual time=0.086..0.087 rows=27 loops=1)                                      |
                    Buckets: 1024  Batches: 1  Memory Usage: 10kB                                                                           |
                    ->  Bitmap Heap Scan on seances s  (cost=4.33..15.16 rows=7 width=16) (actual time=0.040..0.069 rows=27 loops=1)        |
                          Recheck Cond: ((start_at)::date = CURRENT_DATE)                                                                   |
                          Heap Blocks: exact=6                                                                                              |
                          ->  Bitmap Index Scan on start_at_idx  (cost=0.00..4.33 rows=7 width=0) (actual time=0.027..0.027 rows=27 loops=1)|
                                Index Cond: ((start_at)::date = CURRENT_DATE)                                                               |
        ->  Hash  (cost=10.30..10.30 rows=30 width=520) (actual time=0.035..0.036 rows=9 loops=1)                                           |
              Buckets: 1024  Batches: 1  Memory Usage: 9kB                                                                                  |
              ->  Seq Scan on films f  (cost=0.00..10.30 rows=30 width=520) (actual time=0.019..0.023 rows=9 loops=1)                       |
Planning Time: 0.538 ms                                                                                                                     |
Execution Time: 0.405 ms                                                                                                                    |

Оптимизировано с помощью create index start_at_idx on seances (DATE(start_at)) с запроса № 1;
