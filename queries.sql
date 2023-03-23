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

   Sort (cost=279.42..279.73 rows=125 width=56) (actual time=0.943..0.950 rows=125 loops=1)
   Sort Key: s.start_time
   Sort Method: quicksort  Memory: 34kB
   ->  Hash Join  (cost=10.35..275.06 rows=125 width=56) (actual time=0.186..0.783 rows=125 loops=1)
         Hash Cond: (s.movie_id = m.id)
         ->  Index Only Scan using sessions_movie_id_hall_id_date_start_time_finish_time_key on sessions s  (cost=0.29..263.73 rows=125 width=28) (actual time=0.019..0.495 rows=125 loops=1)
               Index Cond: (date = CURRENT_DATE)
               Heap Fetches: 0
         ->  Hash  (cost=7.25..7.25 rows=225 width=28) (actual time=0.101..0.101 rows=225 loops=1)
               Buckets: 1024  Batches: 1  Memory Usage: 22kB
               ->  Seq Scan on movies m  (cost=0.00..7.25 rows=225 width=28) (actual time=0.007..0.042 rows=225 loops=1)
Planning Time: 3.783 ms
Execution Time: 1.092 ms */

-- Добавить составной индекс на date, start_time
CREATE INDEX sessions_date_idx ON sessions(date, start_time);

/* Performance

   Sort  (cost=112.94..113.25 rows=125 width=56) (actual time=0.617..0.623 rows=125 loops=1)
   Sort Key: s.start_time
   Sort Method: quicksort  Memory: 34kB
   ->  Hash Join  (cost=12.57..108.58 rows=125 width=56) (actual time=0.307..0.547 rows=125 loops=1)
         Hash Cond: (s.movie_id = m.id)
         ->  Bitmap Heap Scan on sessions s  (cost=2.51..97.24 rows=125 width=28) (actual time=0.191..0.312 rows=125 loops=1)
               Recheck Cond: (date = CURRENT_DATE)
               Heap Blocks: exact=89
               ->  Bitmap Index Scan on sessions_date_idx  (cost=0.00..2.48 rows=125 width=0) (actual time=0.176..0.176 rows=125 loops=1)
                     Index Cond: (date = CURRENT_DATE)
         ->  Hash  (cost=7.25..7.25 rows=225 width=28) (actual time=0.095..0.095 rows=225 loops=1)
               Buckets: 1024  Batches: 1  Memory Usage: 22kB
               ->  Seq Scan on movies m  (cost=0.00..7.25 rows=225 width=28) (actual time=0.006..0.039 rows=225 loops=1)
 Planning Time: 0.865 ms
 Execution Time: 0.743 ms

 Благодаря индексу на дату сеанса
 удалось сократить стоимость запроса в два раза
 и ускорить запрос ~ на треть */

-- 2. Подсчёт проданных билетов за неделю
EXPLAIN (ANALYSE)
SELECT to_char(SUM(price), '999 999 999 999.99') AS total FROM tickets
WHERE paid_at IS NOT NULL
    AND paid_at::date BETWEEN CURRENT_DATE - INTERVAL '1 WEEK' AND CURRENT_DATE;

/* Performance

   Finalize Aggregate  (cost=625721.31..625721.33 rows=1 width=32) (actual time=6989.116..6989.622 rows=1 loops=1)
   ->  Gather  (cost=625721.20..625721.31 rows=1 width=8) (actual time=6989.038..6989.544 rows=1 loops=1)
         Workers Planned: 1
         Workers Launched: 0
         ->  Partial Aggregate  (cost=624721.20..624721.21 rows=1 width=8) (actual time=6985.346..6985.347 rows=1 loops=1)
               ->  Parallel Seq Scan on tickets  (cost=0.00..624570.44 rows=60304 width=4) (actual time=859.796..6869.921 rows=2142450 loops=1)
                     Filter: ((paid_at IS NOT NULL) AND ((paid_at)::date <= CURRENT_DATE) AND ((paid_at)::date >= (CURRENT_DATE - '7 days'::interval)))
                     Rows Removed by Filter: 18360675
 Planning Time: 1.514 ms
 JIT:
   Functions: 7
   Options: Inlining true, Optimization true, Expressions true, Deforming true
   Timing: Generation 5.024 ms, Inlining 682.541 ms, Optimization 109.618 ms, Emission 67.412 ms, Total 864.595 ms
 Execution Time: 7270.833 ms */

-- Добавить частичный индекс - where paid_at IS NOT NULL
CREATE INDEX tickets_paid_at ON tickets(paid_at) WHERE paid_at IS NOT NULL;

/* Performance

   Finalize Aggregate  (cost=625721.05..625721.07 rows=1 width=32) (actual time=4983.925..4984.027 rows=1 loops=1)
   ->  Gather  (cost=625720.94..625721.05 rows=1 width=8) (actual time=4983.908..4984.009 rows=1 loops=1)
         Workers Planned: 1
         Workers Launched: 0
         ->  Partial Aggregate  (cost=624720.94..624720.95 rows=1 width=8) (actual time=4983.598..4983.598 rows=1 loops=1)
               ->  Parallel Seq Scan on tickets  (cost=0.00..624570.18 rows=60304 width=4) (actual time=207.371..4872.407 rows=2142450 loops=1)
                     Filter: ((paid_at IS NOT NULL) AND ((paid_at)::date <= CURRENT_DATE) AND ((paid_at)::date >= (CURRENT_DATE - '7 days'::interval)))
                     Rows Removed by Filter: 18360675
 Planning Time: 0.213 ms
 JIT:
   Functions: 7
   Options: Inlining true, Optimization true, Expressions true, Deforming true
   Timing: Generation 2.973 ms, Inlining 47.135 ms, Optimization 104.763 ms, Emission 55.084 ms, Total 209.955 ms
 Execution Time: 4987.156 ms

 При полностью заполненном поле paid_at не оказало никакога эффекта,
 сам индекс при этом занимает немного места.
 В реальности, скорее всего, это бы повлияло на стоимость запроса.
*/

-- Создать materialized view для подсчёта сумм продаж
CREATE MATERIALIZED VIEW tickets_stats AS SELECT
    (
        SELECT SUM(price)
        FROM tickets
        WHERE paid_at IS NOT NULL
            AND paid_at::date = CURRENT_DATE
    ) today_total,
    (
        SELECT SUM(price)
        FROM tickets
        WHERE paid_at IS NOT NULL
          AND paid_at::date BETWEEN CURRENT_DATE - INTERVAL '1 WEEK' AND CURRENT_DATE
    ) last_week_total,
    (
        SELECT SUM(price)
        FROM tickets
        WHERE paid_at IS NOT NULL
          AND paid_at::date BETWEEN CURRENT_DATE - INTERVAL '1 MONTH' AND CURRENT_DATE
    ) last_month_total;

REFRESH MATERIALIZED VIEW tickets_stats;

SELECT last_week_total FROM tickets_stats;

/* Performance

   Seq Scan on tickets_stats  (cost=0.00..25.70 rows=1570 width=8) (actual time=0.047..0.048 rows=1 loops=1)
   Planning Time: 0.409 ms
   Execution Time: 0.067 ms */

-- 3. Формирование афиши (фильмы, которые показывают сегодня) 1 запрос.


-- 4. Поиск 3 самых прибыльных фильмов за неделю
SELECT
    m.title, to_char(SUM(t.price), '999 999 999 999.99') as total
FROM
    movies m
    JOIN sessions s ON s.movie_id = m.id
    JOIN tickets t ON t.session_id = s.id
WHERE
    t.paid_at IS NOT NULL
    AND t.paid_at::date BETWEEN CURRENT_DATE - INTERVAL '1 WEEK' AND CURRENT_DATE
GROUP BY
    m.id
ORDER BY
    SUM(t.price) DESC
LIMIT 3;

/* Performance

   Limit  (cost=632147.15..632147.16 rows=3 width=60) (actual time=7153.803..7153.892 rows=3 loops=1)
   ->  Sort  (cost=632147.15..632147.71 rows=225 width=60) (actual time=6752.643..6752.730 rows=3 loops=1)
         Sort Key: (sum(t.price)) DESC
         Sort Method: top-N heapsort  Memory: 25kB
         ->  Finalize GroupAggregate  (cost=630905.54..632144.24 rows=225 width=60) (actual time=6009.740..6752.397 rows=225 loops=1)
               Group Key: m.id
               ->  Gather Merge  (cost=630905.54..632140.30 rows=225 width=36) (actual time=6006.942..6751.734 rows=225 loops=1)
                     Workers Planned: 1
                     Workers Launched: 0
                     ->  Partial GroupAggregate  (cost=629905.53..631114.98 rows=225 width=36) (actual time=6005.145..6749.780 rows=225 loops=1)
                           Group Key: m.id
                           ->  Merge Join  (cost=629905.53..630811.21 rows=60304 width=32) (actual time=6000.942..6642.727 rows=2142450 loops=1)
                                 Merge Cond: (s.movie_id = m.id)
                                 ->  Sort  (cost=629889.49..630040.25 rows=60304 width=20) (actual time=6000.650..6350.631 rows=2142450 loops=1)
                                       Sort Key: s.movie_id
                                       Sort Method: external merge  Disk: 62912kB
                                       ->  Hash Join  (cost=372.81..625101.36 rows=60304 width=20) (actual time=3.346..4814.347 rows=2142450 loops=1)
                                             Hash Cond: (t.session_id = s.id)
                                             ->  Parallel Seq Scan on tickets t  (cost=0.00..624570.18 rows=60304 width=20) (actual time=0.098..4352.526 rows=2142450 loops=1)
                                                   Filter: ((paid_at IS NOT NULL) AND ((paid_at)::date <= CURRENT_DATE) AND ((paid_at)::date >= (CURRENT_DATE - '7 days'::interval)))
                                                   Rows Removed by Filter: 18360675
                                             ->  Hash  (cost=246.25..246.25 rows=10125 width=32) (actual time=3.137..3.138 rows=10125 loops=1)
                                                   Buckets: 16384  Batches: 1  Memory Usage: 761kB
                                                   ->  Seq Scan on sessions s  (cost=0.00..246.25 rows=10125 width=32) (actual time=0.013..1.096 rows=10125 loops=1)
                                 ->  Sort  (cost=16.04..16.60 rows=225 width=28) (actual time=0.245..0.291 rows=225 loops=1)
                                       Sort Key: m.id
                                       Sort Method: quicksort  Memory: 40kB
                                       ->  Seq Scan on movies m  (cost=0.00..7.25 rows=225 width=28) (actual time=0.025..0.054 rows=225 loops=1)
 Planning Time: 2.919 ms
 JIT:
   Functions: 29
   Options: Inlining true, Optimization true, Expressions true, Deforming true
   Timing: Generation 3.996 ms, Inlining 42.522 ms, Optimization 214.222 ms, Emission 144.515 ms, Total 405.254 ms
 Execution Time: 7166.393 ms
 */

-- Добавить индекс на внешний ключ session_id, movie_id
CREATE INDEX tickets_sessions_id_fkey ON tickets(session_id);
CREATE INDEX sessions_movie_id_fkey ON sessions(movie_id);

/* Performance
  Добавление индексов никак не повлияло. */

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
        WHEN paid_at IS NULL THEN 'Свободно'
        WHEN paid_at IS NOT NULL THEN 'Забронировано'
    END status
FROM
    tickets t, session_seats s, clients c
WHERE
    s.session_id = t.session_id
    AND s.seat_id = t.seat_id
    AND c.id = t.client_id
ORDER BY
    s.row, s.number, client_id;

/* Performance

  Sort  (cost=375.11..375.22 rows=45 width=108) (actual time=21.364..21.375 rows=45 loops=1)
   Sort Key: s."row", s.number, t.client_id, s.seat_id
   Sort Method: quicksort  Memory: 31kB
   CTE session_seats
     ->  Nested Loop  (cost=297.32..299.41 rows=3 width=56) (actual time=18.206..18.229 rows=3 loops=1)
           CTE hall
             ->  Index Scan using sessions_pkey on sessions sessions_1  (cost=293.39..295.90 rows=1 width=32) (actual time=17.471..17.475 rows=1 loops=1)
                   Index Cond: (id = $0)
                   InitPlan 1 (returns $0)
                     ->  Limit  (cost=293.10..293.10 rows=1 width=24) (actual time=17.416..17.419 rows=1 loops=1)
                           ->  Sort  (cost=293.10..318.41 rows=10125 width=24) (actual time=17.414..17.416 rows=1 loops=1)
                                 Sort Key: (random())
                                 Sort Method: top-N heapsort  Memory: 25kB
                                 ->  Index Only Scan using sessions_pkey on sessions  (cost=0.29..242.47 rows=10125 width=24) (actual time=4.290..15.672 rows=10125 loops=1)
                                       Heap Fetches: 0
           ->  CTE Scan on hall  (cost=0.00..0.02 rows=1 width=32) (actual time=17.473..17.475 rows=1 loops=1)
           ->  Bitmap Heap Scan on seats  (cost=1.42..3.46 rows=3 width=40) (actual time=0.722..0.739 rows=3 loops=1)
                 Recheck Cond: (hall_id = hall.hall_id)
                 Heap Blocks: exact=2
                 ->  Bitmap Index Scan on seats_hall_id_row_number_key  (cost=0.00..1.42 rows=3 width=0) (actual time=0.026..0.026 rows=3 loops=1)
                       Index Cond: (hall_id = hall.hall_id)
   ->  Hash Join  (cost=11.69..74.46 rows=45 width=108) (actual time=19.638..21.218 rows=45 loops=1)
         Hash Cond: (t.client_id = c.id)
         ->  Nested Loop  (cost=0.56..63.10 rows=45 width=52) (actual time=19.119..20.609 rows=45 loops=1)
               ->  CTE Scan on session_seats s  (cost=0.00..0.06 rows=3 width=40) (actual time=18.209..18.232 rows=3 loops=1)
               ->  Index Scan using tickets_session_id_seat_id_client_id_key on tickets t  (cost=0.56..20.86 rows=15 width=60) (actual time=0.560..0.781 rows=15 loops=3)
                     Index Cond: ((session_id = s.session_id) AND (seat_id = s.seat_id))
         ->  Hash  (cost=10.50..10.50 rows=50 width=1048) (actual time=0.288..0.289 rows=15 loops=1)
               Buckets: 1024  Batches: 1  Memory Usage: 10kB
               ->  Seq Scan on clients c  (cost=0.00..10.50 rows=50 width=1048) (actual time=0.263..0.266 rows=15 loops=1)
 Planning Time: 9.531 ms
 Execution Time: 21.815 ms*/

-- Создать функциональный индекс для формирования полного имени клиентов
CREATE INDEX clients_fullname ON clients ((firstname || ' ' || lastname));

/* Performance

   Sort  (cost=365.45..365.57 rows=45 width=108) (actual time=11.812..11.818 rows=45 loops=1)
   Sort Key: s."row", s.number, t.client_id, s.seat_id
   Sort Method: quicksort  Memory: 31kB
   CTE session_seats
     ->  Nested Loop  (cost=297.32..299.41 rows=3 width=56) (actual time=3.884..3.896 rows=3 loops=1)
           CTE hall
             ->  Index Scan using sessions_pkey on sessions sessions_1  (cost=293.39..295.90 rows=1 width=32) (actual time=3.821..3.824 rows=1 loops=1)
                   Index Cond: (id = $0)
                   InitPlan 1 (returns $0)
                     ->  Limit  (cost=293.10..293.10 rows=1 width=24) (actual time=3.780..3.782 rows=1 loops=1)
                           ->  Sort  (cost=293.10..318.41 rows=10125 width=24) (actual time=3.779..3.780 rows=1 loops=1)
                                 Sort Key: (random())
                                 Sort Method: top-N heapsort  Memory: 25kB
                                 ->  Index Only Scan using sessions_pkey on sessions  (cost=0.29..242.47 rows=10125 width=24) (actual time=0.035..1.644 rows=10125 loops=1)
                                       Heap Fetches: 0
           ->  CTE Scan on hall  (cost=0.00..0.02 rows=1 width=32) (actual time=3.822..3.824 rows=1 loops=1)
           ->  Bitmap Heap Scan on seats  (cost=1.42..3.46 rows=3 width=40) (actual time=0.036..0.043 rows=3 loops=1)
                 Recheck Cond: (hall_id = hall.hall_id)
                 Heap Blocks: exact=2
                 ->  Bitmap Index Scan on seats_hall_id_row_number_key  (cost=0.00..1.42 rows=3 width=0) (actual time=0.022..0.022 rows=3 loops=1)
                       Index Cond: (hall_id = hall.hall_id)
   ->  Hash Join  (cost=1.90..64.81 rows=45 width=108) (actual time=8.586..11.759 rows=45 loops=1)
         Hash Cond: (t.client_id = c.id)
         ->  Nested Loop  (cost=0.56..63.10 rows=45 width=52) (actual time=8.520..11.619 rows=45 loops=1)
               ->  CTE Scan on session_seats s  (cost=0.00..0.06 rows=3 width=40) (actual time=3.886..3.899 rows=3 loops=1)
               ->  Index Scan using tickets_session_id_seat_id_client_id_key on tickets t  (cost=0.56..20.86 rows=15 width=60) (actual time=1.823..2.562 rows=15 loops=3)
                     Index Cond: ((session_id = s.session_id) AND (seat_id = s.seat_id))
         ->  Hash  (cost=1.15..1.15 rows=15 width=1048) (actual time=0.038..0.039 rows=15 loops=1)
               Buckets: 1024  Batches: 1  Memory Usage: 10kB
               ->  Seq Scan on clients c  (cost=0.00..1.15 rows=15 width=1048) (actual time=0.009..0.012 rows=15 loops=1)
 Planning Time: 0.470 ms
 Execution Time: 12.056 ms

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

   HashAggregate  (cost=1852.54..1872.79 rows=2025 width=40) (actual time=331.570..331.587 rows=1 loops=1)
   Group Key: s.id, m.title
   Batches: 1  Memory Usage: 121kB
   ->  Nested Loop  (cost=293.98..1832.29 rows=2025 width=36) (actual time=3.887..328.569 rows=2025 loops=1)
         ->  Nested Loop  (cost=293.54..297.22 rows=1 width=48) (actual time=3.342..3.347 rows=1 loops=1)
               ->  Nested Loop  (cost=293.40..295.93 rows=1 width=52) (actual time=3.315..3.319 rows=1 loops=1)
                     ->  HashAggregate  (cost=293.11..293.12 rows=1 width=16) (actual time=3.254..3.256 rows=1 loops=1)
                           Group Key: sessions.id
                           Batches: 1  Memory Usage: 24kB
                           ->  Limit  (cost=293.10..293.10 rows=1 width=24) (actual time=3.245..3.248 rows=1 loops=1)
                                 ->  Sort  (cost=293.10..318.41 rows=10125 width=24) (actual time=3.244..3.245 rows=1 loops=1)
                                       Sort Key: (random())
                                       Sort Method: top-N heapsort  Memory: 25kB
                                       ->  Index Only Scan using sessions_pkey on sessions  (cost=0.29..242.47 rows=10125 width=24) (actual time=0.024..1.810 rows=10125 loops=1)
                                             Heap Fetches: 0
                     ->  Index Scan using sessions_pkey on sessions s  (cost=0.29..2.80 rows=1 width=36) (actual time=0.056..0.056 rows=1 loops=1)
                           Index Cond: (id = sessions.id)
               ->  Index Scan using movies_pkey on movies m  (cost=0.14..1.29 rows=1 width=28) (actual time=0.024..0.024 rows=1 loops=1)
                     Index Cond: (id = s.movie_id)
         ->  Index Scan using tickets_sessions_id_fkey on tickets t  (cost=0.44..1514.71 rows=2036 width=20) (actual time=0.542..323.968 rows=2025 loops=1)
               Index Cond: (session_id = s.id)
 Planning Time: 3.156 ms
 Execution Time: 331.970 ms
 */

 -- Можно создать Materialized View с данными о мин. и макс. цене по всем сеансам,
 -- что позволит обновлять их по расписанию и снизить нагрузку
