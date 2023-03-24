-- 1. Выбор всех фильмов на сегодня
SELECT
    m.title,
    TO_CHAR(CURRENT_DATE + s.start_time, 'HH24:MI') as session_start
FROM
    sessions s
    JOIN movies m ON s.movie_id = m.id
WHERE
    s.date = CURRENT_DATE
ORDER BY
    s.start_time;

/* Performance

   Sort  (cost=143.02..143.17 rows=58 width=56) (actual time=9.553..9.557 rows=58 loops=1)
   Sort Key: s.start_time
   Sort Method: quicksort  Memory: 29kB
   ->  Hash Join  (cost=7.52..141.32 rows=58 width=56) (actual time=0.607..9.371 rows=58 loops=1)
         Hash Cond: (s.movie_id = m.id)
         ->  Index Only Scan using sessions_movie_id_hall_id_date_start_time_finish_time_key on sessions s  (cost=0.29..133.50 rows=58 width=28) (actual time=0.350..8.951 rows=58 loops=1)
               Index Cond: (date = CURRENT_DATE)
               Heap Fetches: 0
         ->  Hash  (cost=5.44..5.44 rows=144 width=28) (actual time=0.111..0.112 rows=144 loops=1)
               Buckets: 1024  Batches: 1  Memory Usage: 17kB
               ->  Seq Scan on movies m  (cost=0.00..5.44 rows=144 width=28) (actual time=0.017..0.048 rows=144 loops=1)
 Planning Time: 8.551 ms
 Execution Time: 9.754 ms */

-- Добавить составной индекс на date, start_time
CREATE INDEX sessions_date_idx ON sessions(date, start_time);

/* Performance

   Sort  (cost=57.02..57.17 rows=58 width=56) (actual time=0.341..0.345 rows=58 loops=1)
   Sort Key: s.start_time
   Sort Method: quicksort  Memory: 29kB
   ->  Hash Join  (cost=9.22..55.32 rows=58 width=56) (actual time=0.157..0.304 rows=58 loops=1)
         Hash Cond: (s.movie_id = m.id)
         ->  Bitmap Heap Scan on sessions s  (cost=1.98..47.50 rows=58 width=28) (actual time=0.055..0.144 rows=58 loops=1)
               Recheck Cond: (date = CURRENT_DATE)
               Heap Blocks: exact=44
               ->  Bitmap Index Scan on sessions_date_idx  (cost=0.00..1.97 rows=58 width=0) (actual time=0.041..0.041 rows=58 loops=1)
                     Index Cond: (date = CURRENT_DATE)
         ->  Hash  (cost=5.44..5.44 rows=144 width=28) (actual time=0.081..0.081 rows=144 loops=1)
               Buckets: 1024  Batches: 1  Memory Usage: 17kB
               ->  Seq Scan on movies m  (cost=0.00..5.44 rows=144 width=28) (actual time=0.007..0.026 rows=144 loops=1)
 Planning Time: 0.934 ms
 Execution Time: 0.447 ms

 Благодаря индексу на дату сеанса
 удалось сократить стоимость запроса более чем в два раза
 и ускорить запрос более чем в 10 раз */

-- 2. Подсчёт проданных билетов за неделю
SELECT
    to_char(SUM(tickets.price), '999 999 999 999.99') AS total
FROM tickets
    JOIN payments p on tickets.id = p.ticket_id
WHERE tickets.status = 1
    AND p.paid IS true
    AND tickets.created_at::date BETWEEN CURRENT_DATE - INTERVAL '1 WEEK' AND CURRENT_DATE;

/* Performance

   Finalize Aggregate  (cost=343513.36..343513.37 rows=1 width=32) (actual time=4065.219..4066.402 rows=1 loops=1)
   ->  Gather  (cost=343513.25..343513.36 rows=1 width=8) (actual time=4065.200..4066.383 rows=1 loops=1)
         Workers Planned: 1
         Workers Launched: 0
         ->  Partial Aggregate  (cost=342513.25..342513.26 rows=1 width=8) (actual time=4063.076..4063.080 rows=1 loops=1)
               ->  Parallel Hash Join  (cost=208189.18..342508.29 rows=1984 width=4) (actual time=1987.071..4053.888 rows=87154 loops=1)
                     Hash Cond: (p.ticket_id = tickets.id)
                     ->  Parallel Seq Scan on payments p  (cost=0.00..129099.96 rows=1988249 width=16) (actual time=0.112..1356.393 rows=3359363 loops=1)
                           Filter: (paid IS TRUE)
                           Rows Removed by Filter: 3359101
                     ->  Parallel Hash  (cost=208139.88..208139.88 rows=3944 width=20) (actual time=1986.105..1986.105 rows=174602 loops=1)
                           Buckets: 262144 (originally 8192)  Batches: 1 (originally 1)  Memory Usage: 13600kB
                           ->  Parallel Seq Scan on tickets  (cost=0.00..208139.88 rows=3944 width=20) (actual time=49.351..1823.552 rows=174602 loops=1)
                                 Filter: ((status = 1) AND ((created_at)::date <= CURRENT_DATE) AND ((created_at)::date >= (CURRENT_DATE - '7 days'::interval)))
                                 Rows Removed by Filter: 6543862
 Planning Time: 7.416 ms
 JIT:
   Functions: 18
   Options: Inlining false, Optimization false, Expressions true, Deforming true
   Timing: Generation 14.666 ms, Inlining 0.000 ms, Optimization 2.897 ms, Emission 46.361 ms, Total 63.924 ms
 Execution Time: 4375.044 ms */

-- Добавить частичный индекс - where status = 1,
-- Добавить индекс на поле paid в платежах
-- Добавить функциональный индекс на дату и указать таймзону в запросе
CREATE INDEX tickets_created_date ON tickets((timezone('UTC', created_at)::date));
CREATE INDEX tickets_paid_status ON tickets(status) WHERE status = 1;
CREATE INDEX payments_paid ON payments(paid) WHERE paid IS true;

SELECT
    to_char(SUM(tickets.price), '999 999 999 999.99') AS total
FROM tickets
    JOIN payments p on tickets.id = p.ticket_id
WHERE tickets.status = 1
  AND p.paid IS true
  AND timezone('UTC', tickets.created_at)::date BETWEEN CURRENT_DATE - INTERVAL '1 WEEK' AND CURRENT_DATE;

/* Performance

   Finalize Aggregate  (cost=151660.82..151660.83 rows=1 width=32) (actual time=2245.461..2247.989 rows=1 loops=1)
   ->  Gather  (cost=151660.71..151660.82 rows=1 width=8) (actual time=2245.443..2247.971 rows=1 loops=1)
         Workers Planned: 1
         Workers Launched: 0
         ->  Partial Aggregate  (cost=150660.71..150660.72 rows=1 width=8) (actual time=2245.104..2245.109 rows=1 loops=1)
               ->  Parallel Hash Join  (cost=16336.16..150655.75 rows=1984 width=4) (actual time=649.615..2238.028 rows=87154 loops=1)
                     Hash Cond: (p.ticket_id = tickets.id)
                     ->  Parallel Seq Scan on payments p  (cost=0.00..129100.38 rows=1988270 width=16) (actual time=0.038..846.265 rows=3359363 loops=1)
                           Filter: (paid IS TRUE)
                           Rows Removed by Filter: 3359101
                     ->  Parallel Hash  (cost=16286.86..16286.86 rows=3944 width=20) (actual time=649.220..649.222 rows=174602 loops=1)
                           Buckets: 262144 (originally 8192)  Batches: 1 (originally 1)  Memory Usage: 13600kB
                           ->  Parallel Bitmap Heap Scan on tickets  (cost=8502.92..16286.86 rows=3944 width=20) (actual time=153.600..575.703 rows=174602 loops=1)
                                 Recheck Cond: (((timezone('UTC'::text, created_at))::date >= (CURRENT_DATE - '7 days'::interval)) AND ((timezone('UTC'::text, created_at))::date <= CURRENT_DATE) AND (status = 1))
                                 Heap Blocks: exact=77249
                                 ->  BitmapAnd  (cost=8502.92..8502.92 rows=6705 width=0) (actual time=137.370..137.371 rows=0 loops=1)
                                       ->  Bitmap Index Scan on tickets_created_date  (cost=0.00..372.61 rows=33592 width=0) (actual time=83.559..83.559 rows=872406 loops=1)
                                             Index Cond: (((timezone('UTC'::text, created_at))::date >= (CURRENT_DATE - '7 days'::interval)) AND ((timezone('UTC'::text, created_at))::date <= CURRENT_DATE))
                                       ->  Bitmap Index Scan on tickets_paid_status  (cost=0.00..8126.70 rows=1341005 width=0) (actual time=50.016..50.016 rows=1343544 loops=1)
 Planning Time: 0.459 ms
 JIT:
   Functions: 20
   Options: Inlining false, Optimization false, Expressions true, Deforming true
   Timing: Generation 1.292 ms, Inlining 0.000 ms, Optimization 0.533 ms, Emission 16.824 ms, Total 18.649 ms
 Execution Time: 2249.504 ms

   Стоимость запроса и время выполнения сократилась в два раза
*/

-- Создать materialized view для подсчёта сумм продаж
CREATE MATERIALIZED VIEW tickets_stats AS SELECT
    (
        SELECT
            to_char(SUM(tickets.price), '999 999 999 999.99') AS total
        FROM tickets
            JOIN payments p on tickets.id = p.ticket_id
        WHERE tickets.status = 1
          AND p.paid IS true
          AND timezone('UTC', tickets.created_at)::date = CURRENT_DATE
    ) today_total,
    (
        SELECT
            to_char(SUM(tickets.price), '999 999 999 999.99') AS total
        FROM tickets
            JOIN payments p on tickets.id = p.ticket_id
        WHERE tickets.status = 1
          AND p.paid IS true
          AND timezone('UTC', tickets.created_at)::date BETWEEN CURRENT_DATE - INTERVAL '1 WEEK' AND CURRENT_DATE
    ) last_week_total,
    (
        SELECT
            to_char(SUM(tickets.price), '999 999 999 999.99') AS total
        FROM tickets
            JOIN payments p on tickets.id = p.ticket_id
        WHERE tickets.status = 1
          AND p.paid IS true
          AND timezone('UTC', tickets.created_at)::date BETWEEN CURRENT_DATE - INTERVAL '1 MONTH' AND CURRENT_DATE
    ) last_month_total;

REFRESH MATERIALIZED VIEW tickets_stats;

SELECT last_week_total FROM tickets_stats;

/* Performance

 Seq Scan on tickets_stats  (cost=0.00..16.50 rows=650 width=32) (actual time=0.013..0.014 rows=1 loops=1)
 Planning Time: 0.242 ms
 Execution Time: 0.027 ms */

-- 3. Формирование афиши (фильмы, которые показывают сегодня) 1 запрос.


-- 4. Поиск 3 самых прибыльных фильмов за неделю
SELECT
    m.title, to_char(SUM(t.price), '999 999 999 999.99') as total
FROM
    movies m
    JOIN sessions s ON s.movie_id = m.id
    JOIN tickets t ON t.session_id = s.id
    JOIN payments p ON p.ticket_id = p.id
WHERE
    t.status = 1
    AND p.paid IS true
    AND timezone('UTC', t.created_at)::date BETWEEN CURRENT_DATE - INTERVAL '1 WEEK' AND CURRENT_DATE
GROUP BY
    m.id
ORDER BY
    SUM(t.price) DESC
LIMIT 3;

/* Performance

   Limit  (cost=1452096.54..1452096.55 rows=3 width=68) (actual time=2082.942..2084.880 rows=0 loops=1)
   ->  Sort  (cost=1452096.54..1452096.90 rows=144 width=68) (actual time=1320.945..1322.881 rows=0 loops=1)
         Sort Key: (sum(t.price)) DESC
         Sort Method: quicksort  Memory: 25kB
         ->  Finalize GroupAggregate  (cost=1452075.60..1452094.68 rows=144 width=68) (actual time=1320.859..1322.795 rows=0 loops=1)
               Group Key: m.id
               ->  Gather Merge  (cost=1452075.60..1452092.16 rows=144 width=36) (actual time=1320.856..1322.792 rows=0 loops=1)
                     Workers Planned: 1
                     Workers Launched: 0
                     ->  Sort  (cost=1451075.59..1451075.95 rows=144 width=36) (actual time=1320.443..1320.449 rows=0 loops=1)
                           Sort Key: m.id
                           Sort Method: quicksort  Memory: 25kB
                           ->  Partial HashAggregate  (cost=1451068.98..1451070.42 rows=144 width=36) (actual time=1320.408..1320.414 rows=0 loops=1)
                                 Group Key: m.id
                                 Batches: 1  Memory Usage: 40kB
                                 ->  Hash Join  (cost=237989.03..1117791.04 rows=66655588 width=32) (actual time=1320.403..1320.409 rows=0 loops=1)
                                       Hash Cond: (s.movie_id = m.id)
                                       ->  Hash Join  (cost=8320.02..121575.18 rows=3944 width=20) (actual time=143.959..143.963 rows=1 loops=1)
                                             Hash Cond: (t.session_id = s.id)
                                             ->  Parallel Bitmap Heap Scan on tickets t  (cost=8128.38..121373.17 rows=3944 width=20) (actual time=140.882..140.883 rows=1 loops=1)
                                                   Recheck Cond: (status = 1)
                                                   Filter: (((created_at)::date <= CURRENT_DATE) AND ((created_at)::date >= (CURRENT_DATE - '7 days'::interval)))
                                                   Rows Removed by Filter: 9
                                                   Heap Blocks: exact=1
                                                   ->  Bitmap Index Scan on tickets_paid_status  (cost=0.00..8126.70 rows=1341005 width=0) (actual time=122.445..122.446 rows=1343544 loops=1)
                                             ->  Hash  (cost=126.84..126.84 rows=5184 width=32) (actual time=3.019..3.020 rows=5184 loops=1)
                                                   Buckets: 8192  Batches: 1  Memory Usage: 388kB
                                                   ->  Seq Scan on sessions s  (cost=0.00..126.84 rows=5184 width=32) (actual time=0.090..1.836 rows=5184 loops=1)
                                       ->  Hash  (cost=182613.01..182613.01 rows=2433600 width=28) (actual time=1161.816..1161.817 rows=0 loops=1)
                                             Buckets: 1048576  Batches: 4  Memory Usage: 8198kB
                                             ->  Nested Loop  (cost=20356.47..182613.01 rows=2433600 width=28) (actual time=1161.814..1161.815 rows=0 loops=1)
                                                   ->  Bitmap Heap Scan on payments p  (cost=20356.47..152187.21 rows=16900 width=0) (actual time=1161.813..1161.813 rows=0 loops=1)
                                                         Recheck Cond: (paid IS TRUE)
                                                         Filter: (ticket_id = id)
                                                         Rows Removed by Filter: 3359363
                                                         Heap Blocks: exact=89580
                                                         ->  Bitmap Index Scan on payments_paid  (cost=0.00..20352.24 rows=3380059 width=0) (actual time=145.742..145.742 rows=3359363 loops=1)
                                                   ->  Materialize  (cost=0.00..6.16 rows=144 width=28) (never executed)
                                                         ->  Seq Scan on movies m  (cost=0.00..5.44 rows=144 width=28) (never executed)
 Planning Time: 10.551 ms
 JIT:
   Functions: 39
   Options: Inlining true, Optimization true, Expressions true, Deforming true
   Timing: Generation 2.956 ms, Inlining 167.284 ms, Optimization 342.352 ms, Emission 252.423 ms, Total 765.016 ms
 Execution Time: 2088.847 ms */

-- Добавить индексы на внешние ключи
CREATE INDEX tickets_session_id_fkey ON tickets(session_id);
CREATE INDEX sessions_movie_id_fkey ON sessions(movie_id);
CREATE INDEX payments_ticket_id_fkey ON tickets(session_id);

/* Performance
  Добавление индексов никак не повлияло.
  Немного уменьшило стоимость запроса
  использование индекса timezone('UTC', created_at)::date */

-- 5. Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
WITH session_seats AS (
    WITH hall AS (
        SELECT id as session_id, hall_id
        FROM sessions
        WHERE id = (SELECT id FROM sessions ORDER BY RANDOM() LIMIT 1)
    )
    SELECT session_id, hall.hall_id, seats.id as seat_id, row, number
    FROM seats, hall
    WHERE seats.hall_id = hall.hall_id
)
SELECT
    (c.firstname || ' ' || c.lastname) as client,
    s.seat_id,
    s.row,
    s.number,
    price,
    CASE
        WHEN t.status IN (2, 3, 4) THEN 'Свободно'
        WHEN t.status IN (0, 1) THEN 'Занято'
    END
FROM
    tickets t, session_seats s, clients c
WHERE
    s.session_id = t.session_id
    AND s.seat_id = t.seat_id
    AND c.id = t.client_id
ORDER BY
    s.row, s.number, client_id;

/* Performance

  Sort  (cost=216.50..216.59 rows=36 width=108) (actual time=6.252..6.257 rows=36 loops=1)
   Sort Key: s."row", s.number, t.client_id
   Sort Method: quicksort  Memory: 29kB
   CTE session_seats
     ->  Nested Loop  (cost=158.64..160.73 rows=3 width=56) (actual time=4.019..4.027 rows=3 loops=1)
           CTE hall
             ->  Index Scan using sessions_pkey on sessions sessions_1  (cost=154.71..157.23 rows=1 width=32) (actual time=3.585..3.587 rows=1 loops=1)
                   Index Cond: (id = $0)
                   InitPlan 1 (returns $0)
                     ->  Limit  (cost=154.42..154.43 rows=1 width=24) (actual time=3.551..3.552 rows=1 loops=1)
                           ->  Sort  (cost=154.42..167.38 rows=5184 width=24) (actual time=3.550..3.551 rows=1 loops=1)
                                 Sort Key: (random())
                                 Sort Method: top-N heapsort  Memory: 25kB
                                 ->  Index Only Scan using sessions_pkey on sessions  (cost=0.28..128.50 rows=5184 width=24) (actual time=0.434..2.461 rows=5184 loops=1)
                                       Heap Fetches: 0
           ->  CTE Scan on hall  (cost=0.00..0.02 rows=1 width=32) (actual time=3.586..3.588 rows=1 loops=1)
           ->  Bitmap Heap Scan on seats  (cost=1.42..3.45 rows=3 width=40) (actual time=0.428..0.430 rows=3 loops=1)
                 Recheck Cond: (hall_id = hall.hall_id)
                 Heap Blocks: exact=1
                 ->  Bitmap Index Scan on seats_hall_id_row_number_key  (cost=0.00..1.42 rows=3 width=0) (actual time=0.007..0.007 rows=3 loops=1)
                       Index Cond: (hall_id = hall.hall_id)
   ->  Nested Loop  (cost=0.71..54.84 rows=36 width=108) (actual time=5.471..6.163 rows=36 loops=1)
         ->  Nested Loop  (cost=0.56..51.56 rows=36 width=46) (actual time=4.989..5.600 rows=36 loops=1)
               ->  CTE Scan on session_seats s  (cost=0.00..0.06 rows=3 width=40) (actual time=4.023..4.032 rows=3 loops=1)
               ->  Index Scan using tickets_session_id_seat_id_client_id_key on tickets t  (cost=0.56..17.05 rows=12 width=54) (actual time=0.452..0.515 rows=12 loops=3)
                     Index Cond: ((session_id = s.session_id) AND (seat_id = s.seat_id))
         ->  Memoize  (cost=0.15..0.17 rows=1 width=1048) (actual time=0.014..0.014 rows=1 loops=36)
               Cache Key: t.client_id
               Cache Mode: logical
               Hits: 24  Misses: 12  Evictions: 0  Overflows: 0  Memory Usage: 2kB
               ->  Index Scan using clients_pkey on clients c  (cost=0.14..0.16 rows=1 width=1048) (actual time=0.040..0.040 rows=1 loops=12)
                     Index Cond: (id = t.client_id)
 Planning Time: 7.459 ms
 Execution Time: 6.543 ms */

-- Создать функциональный индекс для формирования полного имени клиентов
CREATE INDEX clients_fullname ON clients ((firstname || ' ' || lastname));

/* Performance

   Sort  (cost=73.39..73.46 rows=30 width=108) (actual time=0.344..0.347 rows=15 loops=1)
   Sort Key: s."row", s.number, t.client_id
   Sort Method: quicksort  Memory: 27kB
   CTE session_seats
     ->  Nested Loop  (cost=16.80..22.33 rows=6 width=56) (actual time=0.168..0.171 rows=3 loops=1)
           CTE hall
             ->  Index Scan using sessions_pkey on sessions sessions_1  (cost=12.84..15.36 rows=1 width=32) (actual time=0.155..0.156 rows=1 loops=1)
                   Index Cond: (id = $0)
                   InitPlan 1 (returns $0)
                     ->  Limit  (cost=12.56..12.56 rows=1 width=24) (actual time=0.132..0.133 rows=1 loops=1)
                           ->  Sort  (cost=12.56..13.50 rows=375 width=24) (actual time=0.132..0.132 rows=1 loops=1)
                                 Sort Key: (random())
                                 Sort Method: top-N heapsort  Memory: 25kB
                                 ->  Seq Scan on sessions  (cost=0.00..10.69 rows=375 width=24) (actual time=0.018..0.065 rows=375 loops=1)
           ->  CTE Scan on hall  (cost=0.00..0.02 rows=1 width=32) (actual time=0.156..0.157 rows=1 loops=1)
           ->  Bitmap Heap Scan on seats  (cost=1.45..6.89 rows=6 width=40) (actual time=0.008..0.009 rows=3 loops=1)
                 Recheck Cond: (hall_id = hall.hall_id)
                 Heap Blocks: exact=1
                 ->  Bitmap Index Scan on seats_hall_id_row_number_key  (cost=0.00..1.45 rows=6 width=0) (actual time=0.004..0.004 rows=3 loops=1)
                       Index Cond: (hall_id = hall.hall_id)
   ->  Nested Loop  (cost=0.56..50.33 rows=30 width=108) (actual time=0.237..0.308 rows=15 loops=1)
         ->  Nested Loop  (cost=0.42..48.44 rows=30 width=46) (actual time=0.212..0.260 rows=15 loops=1)
               ->  CTE Scan on session_seats s  (cost=0.00..0.12 rows=6 width=40) (actual time=0.172..0.176 rows=3 loops=1)
               ->  Index Scan using tickets_session_id_seat_id_client_id_key on tickets t  (cost=0.42..8.00 rows=5 width=54) (actual time=0.022..0.026 rows=5 loops=3)
                     Index Cond: ((session_id = s.session_id) AND (seat_id = s.seat_id))
         ->  Memoize  (cost=0.14..0.16 rows=1 width=1048) (actual time=0.002..0.002 rows=1 loops=15)
               Cache Key: t.client_id
               Cache Mode: logical
               Hits: 10  Misses: 5  Evictions: 0  Overflows: 0  Memory Usage: 1kB
               ->  Index Scan using clients_pkey on clients c  (cost=0.13..0.15 rows=1 width=1048) (actual time=0.004..0.004 rows=1 loops=5)
                     Index Cond: (id = t.client_id)
 Planning Time: 0.801 ms
 Execution Time: 0.538 ms

 Создание функционального индекса снизило стоимость запроса всего на 10 единиц */

-- 6. Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс
SELECT
    m.title,
    s.date,
    MIN(price) as min_price,
    MAX(price) as max_price
FROM
    tickets t
    JOIN sessions s on s.id = t.session_id
    JOIN movies m on s.movie_id = m.id
WHERE
    s.id IN (SELECT id FROM sessions ORDER BY RANDOM() LIMIT 1) -- session_uuid_here
GROUP BY s.id, m.title, s.date;

/* Performance

   HashAggregate  (cost=229.39..242.35 rows=1296 width=40) (actual time=10.552..10.556 rows=1 loops=1)
   Group Key: s.id, m.title
   Batches: 1  Memory Usage: 73kB
   ->  Nested Loop  (cost=155.30..216.43 rows=1296 width=36) (actual time=2.010..9.720 rows=1296 loops=1)
         ->  Nested Loop  (cost=154.87..157.41 rows=1 width=48) (actual time=1.944..1.948 rows=1 loops=1)
               ->  Nested Loop  (cost=154.72..157.25 rows=1 width=52) (actual time=1.926..1.929 rows=1 loops=1)
                     ->  HashAggregate  (cost=154.44..154.45 rows=1 width=16) (actual time=1.864..1.867 rows=1 loops=1)
                           Group Key: sessions.id
                           Batches: 1  Memory Usage: 24kB
                           ->  Limit  (cost=154.42..154.43 rows=1 width=24) (actual time=1.860..1.862 rows=1 loops=1)
                                 ->  Sort  (cost=154.42..167.38 rows=5184 width=24) (actual time=1.859..1.860 rows=1 loops=1)
                                       Sort Key: (random())
                                       Sort Method: top-N heapsort  Memory: 25kB
                                       ->  Index Only Scan using sessions_pkey on sessions  (cost=0.28..128.50 rows=5184 width=24) (actual time=0.024..0.769 rows=5184 loops=1)
                                             Heap Fetches: 0
                     ->  Index Scan using sessions_pkey on sessions s  (cost=0.28..2.80 rows=1 width=36) (actual time=0.059..0.059 rows=1 loops=1)
                           Index Cond: (id = sessions.id)
               ->  Index Scan using movies_pkey on movies m  (cost=0.14..0.16 rows=1 width=28) (actual time=0.016..0.016 rows=1 loops=1)
                     Index Cond: (id = s.movie_id)
         ->  Index Scan using payments_ticket_id_fkey on tickets t  (cost=0.43..46.05 rows=1297 width=20) (actual time=0.064..7.313 rows=1296 loops=1)
               Index Cond: (session_id = s.id)
 Planning Time: 1.242 ms
 Execution Time: 10.785 ms */

 -- Этот запрос выполняется эффективно,
 -- но и кол-во записей в таблице
 -- по сравнению с основными таблицами очень маленькое.
