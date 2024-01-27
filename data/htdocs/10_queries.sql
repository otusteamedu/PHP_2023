-- Фильмы на дату
EXPLAIN ANALYSE
SELECT f.id   as film_id,
       f.name as film_name
FROM films f
         INNER JOIN sessions s on f.id = s.film_id
WHERE s.date = '2024-01-15'
GROUP BY f.id;

/**
 * Без индекса
Group  (cost=0.14..2109.80 rows=8 width=11) (actual time=16.271..16.419 rows=8 loops=1)
  Group Key: f.id
  ->  Nested Loop  (cost=0.14..2109.78 rows=8 width=11) (actual time=16.267..16.410 rows=8 loops=1)
        Join Filter: (f.id = s.film_id)
        Rows Removed by Join Filter: 792
        ->  Index Scan using films_pkey on films f  (cost=0.14..13.64 rows=100 width=11) (actual time=0.028..0.058 rows=100 loops=1)
        ->  Materialize  (cost=0.00..2084.15 rows=8 width=4) (actual time=0.001..0.163 rows=8 loops=100)
              ->  Seq Scan on sessions s  (cost=0.00..2084.11 rows=8 width=4) (actual time=0.033..16.183 rows=8 loops=1)
                    Filter: (date = '2024-01-15'::date)
                    Rows Removed by Filter: 100001
Planning Time: 1.625 ms
Execution Time: 16.488 ms

* Индекс: CREATE INDEX ON sessions(date);
Group  (cost=11.86..11.90 rows=8 width=11) (actual time=0.080..0.084 rows=8 loops=1)
  Group Key: f.id
  ->  Sort  (cost=11.86..11.88 rows=8 width=11) (actual time=0.080..0.081 rows=8 loops=1)
        Sort Key: f.id
        Sort Method: quicksort  Memory: 25kB
        ->  Hash Join  (cost=3.54..11.74 rows=8 width=11) (actual time=0.071..0.075 rows=8 loops=1)
              Hash Cond: (s.film_id = f.id)
              ->  Index Scan using sessions_date_idx on sessions s  (cost=0.29..8.47 rows=8 width=4) (actual time=0.015..0.017 rows=8 loops=1)
                    Index Cond: (date = '2024-01-15'::date)
              ->  Hash  (cost=2.00..2.00 rows=100 width=11) (actual time=0.032..0.033 rows=100 loops=1)
                    Buckets: 1024  Batches: 1  Memory Usage: 13kB
                    ->  Seq Scan on films f  (cost=0.00..2.00 rows=100 width=11) (actual time=0.009..0.017 rows=100 loops=1)
Planning Time: 0.305 ms
Execution Time: 0.107 ms


----
Прирост производительности по времени: 16.488/0.107 = 154.05 раз
Прирост производительности по стоимости: 2109.80/11.90 = 177.14 раз
**/

-- Фильмы за неделю
EXPLAIN ANALYSE
SELECT f.id   as film_id,
       f.name as film_name
FROM films f
         INNER JOIN sessions s on f.id = s.film_id
WHERE s.date BETWEEN '2024-01-20' AND '2024-01-24'
GROUP BY f.id;

/**
 * Без индекса
Group  (cost=2340.62..2341.88 rows=43 width=11) (actual time=16.471..16.539 rows=35 loops=1)
  Group Key: f.id
  ->  Merge Join  (cost=2340.62..2341.77 rows=43 width=11) (actual time=16.469..16.525 rows=40 loops=1)
        Merge Cond: (f.id = s.film_id)
        ->  Sort  (cost=5.32..5.57 rows=100 width=11) (actual time=0.084..0.101 rows=100 loops=1)
              Sort Key: f.id
              Sort Method: quicksort  Memory: 28kB
              ->  Seq Scan on films f  (cost=0.00..2.00 rows=100 width=11) (actual time=0.024..0.036 rows=100 loops=1)
        ->  Sort  (cost=2335.30..2335.41 rows=43 width=4) (actual time=16.364..16.368 rows=40 loops=1)
              Sort Key: s.film_id
              Sort Method: quicksort  Memory: 25kB
              ->  Seq Scan on sessions s  (cost=0.00..2334.14 rows=43 width=4) (actual time=0.182..16.337 rows=40 loops=1)
                    Filter: ((date >= '2024-01-20'::date) AND (date <= '2024-01-24'::date))
                    Rows Removed by Filter: 99969
Planning Time: 0.568 ms
Execution Time: 16.692 ms

 * Индекс: CREATE INDEX ON sessions(date);
HashAggregate  (cost=12.82..13.25 rows=43 width=11) (actual time=0.150..0.158 rows=35 loops=1)
  Group Key: f.id
  Batches: 1  Memory Usage: 24kB
  ->  Hash Join  (cost=3.54..12.71 rows=43 width=11) (actual time=0.104..0.130 rows=40 loops=1)
        Hash Cond: (s.film_id = f.id)
        ->  Index Scan using sessions_date_idx on sessions s  (cost=0.29..9.35 rows=43 width=4) (actual time=0.016..0.029 rows=40 loops=1)
              Index Cond: ((date >= '2024-01-20'::date) AND (date <= '2024-01-24'::date))
        ->  Hash  (cost=2.00..2.00 rows=100 width=11) (actual time=0.068..0.069 rows=100 loops=1)
              Buckets: 1024  Batches: 1  Memory Usage: 13kB
              ->  Seq Scan on films f  (cost=0.00..2.00 rows=100 width=11) (actual time=0.017..0.028 rows=100 loops=1)
Planning Time: 0.425 ms
Execution Time: 0.282 ms

----
Прирост производительности по времени: 16.692/0.282 = 59.22 раз
Прирост производительности по стоимости: 2341.88/13.25 = 176.67 раз
**/

-- Схема зала на сеанс
EXPLAIN ANALYSE SELECT s.id            as session_id,
       se.id           as seat_id_in_hall,
       se.row_number   as row_number,
       se.place_number as place_number,
       t.id            as ticket_id,
       f.name          as film_name
FROM sessions as s
         LEFT JOIN halls as h on s.hall_id = h.id
         LEFT JOIN seats as se on se.hall_id = h.id
         LEFT JOIN films as f on s.film_id = f.id
         LEFT JOIN tickets as t on t.seat_id = se.id AND t.session_id = s.id
WHERE s.id = 100;
/**
 * Без индекса
Nested Loop Left Join  (cost=9.18..38.29 rows=2 width=27) (actual time=0.410..1.214 rows=200 loops=1)
  ->  Nested Loop Left Join  (cost=8.75..24.62 rows=2 width=23) (actual time=0.356..0.521 rows=200 loops=1)
        ->  Nested Loop Left Join  (cost=8.47..18.78 rows=1 width=15) (actual time=0.309..0.340 rows=1 loops=1)
              ->  Hash Right Join  (cost=8.32..10.60 rows=1 width=15) (actual time=0.236..0.265 rows=1 loops=1)
                    Hash Cond: (f.id = s.film_id)
                    ->  Seq Scan on films f  (cost=0.00..2.00 rows=100 width=11) (actual time=0.011..0.025 rows=100 loops=1)
                    ->  Hash  (cost=8.31..8.31 rows=1 width=12) (actual time=0.047..0.048 rows=1 loops=1)
                          Buckets: 1024  Batches: 1  Memory Usage: 9kB
                          ->  Index Scan using sessions_pkey on sessions s  (cost=0.29..8.31 rows=1 width=12) (actual time=0.038..0.039 rows=1 loops=1)
                                Index Cond: (id = 100)
              ->  Index Only Scan using halls_id_key on halls h  (cost=0.15..8.17 rows=1 width=4) (actual time=0.071..0.071 rows=1 loops=1)
                    Index Cond: (id = s.hall_id)
                    Heap Fetches: 1
        ->  Index Scan using seats_hall_id_row_number_place_number_key on seats se  (cost=0.28..3.84 rows=200 width=16) (actual time=0.044..0.121 rows=200 loops=1)
              Index Cond: (hall_id = h.id)
  ->  Index Scan using tickets_session_id_seat_id_key on tickets t  (cost=0.42..6.83 rows=1 width=12) (actual time=0.003..0.003 rows=1 loops=200)
        Index Cond: ((session_id = 100) AND (seat_id = se.id))
Planning Time: 1.779 ms
Execution Time: 1.393 ms

  * Индекс: CREATE INDEX ON tickets USING btree(sale_price);
Nested Loop Left Join  (cost=9.18..38.29 rows=2 width=27) (actual time=0.129..0.812 rows=200 loops=1)
  ->  Nested Loop Left Join  (cost=8.75..24.62 rows=2 width=23) (actual time=0.120..0.244 rows=200 loops=1)
        ->  Nested Loop Left Join  (cost=8.47..18.78 rows=1 width=15) (actual time=0.103..0.129 rows=1 loops=1)
              ->  Hash Right Join  (cost=8.32..10.60 rows=1 width=15) (actual time=0.060..0.084 rows=1 loops=1)
                    Hash Cond: (f.id = s.film_id)
                    ->  Seq Scan on films f  (cost=0.00..2.00 rows=100 width=11) (actual time=0.011..0.022 rows=100 loops=1)
                    ->  Hash  (cost=8.31..8.31 rows=1 width=12) (actual time=0.030..0.031 rows=1 loops=1)
                          Buckets: 1024  Batches: 1  Memory Usage: 9kB
                          ->  Index Scan using sessions_pkey on sessions s  (cost=0.29..8.31 rows=1 width=12) (actual time=0.011..0.013 rows=1 loops=1)
                                Index Cond: (id = 100)
              ->  Index Only Scan using halls_id_key on halls h  (cost=0.15..8.17 rows=1 width=4) (actual time=0.041..0.041 rows=1 loops=1)
                    Index Cond: (id = s.hall_id)
                    Heap Fetches: 1
        ->  Index Scan using seats_hall_id_row_number_place_number_key on seats se  (cost=0.28..3.84 rows=200 width=16) (actual time=0.015..0.080 rows=200 loops=1)
              Index Cond: (hall_id = h.id)
  ->  Index Scan using tickets_session_id_seat_id_key on tickets t  (cost=0.42..6.83 rows=1 width=12) (actual time=0.002..0.002 rows=1 loops=200)
        Index Cond: ((session_id = 100) AND (seat_id = se.id))
Planning Time: 0.534 ms
Execution Time: 0.885 ms

----
Прирост производительности по времени: 1.393/0.885 = 1.57 раз
Прирост производительности по стоимости: 38.29/6.83 = 5.60 раз
**/


-- Минимальная и максимальная стоимость билета на сеанс
EXPLAIN ANALYSE SELECT MIN(t.sale_price)        as min_price,
       MAX(t.sale_price)        as max_price
FROM sessions as s
         LEFT JOIN tickets as t on t.session_id = s.id
WHERE s.id = 100;
/**
 * Без индекса - 48431.39ms
Aggregate  (cost=187.45..187.46 rows=1 width=8) (actual time=0.213..0.214 rows=1 loops=1)
  ->  Nested Loop Left Join  (cost=0.72..186.96 rows=99 width=4) (actual time=0.137..0.188 rows=109 loops=1)
        ->  Index Only Scan using sessions_pkey on sessions s  (cost=0.29..4.31 rows=1 width=4) (actual time=0.115..0.122 rows=1 loops=1)
              Index Cond: (id = 100)
              Heap Fetches: 0
        ->  Index Scan using tickets_session_id_seat_id_key on tickets t  (cost=0.42..181.66 rows=99 width=8) (actual time=0.016..0.046 rows=109 loops=1)
              Index Cond: (session_id = 100)
Planning Time: 0.337 ms
Execution Time: 0.298 ms

  * С индексами:
CREATE INDEX ON sessions(date);
CREATE INDEX ON tickets(sale_price);

Aggregate  (cost=187.45..187.46 rows=1 width=8) (actual time=0.091..0.092 rows=1 loops=1)
  ->  Nested Loop Left Join  (cost=0.72..186.96 rows=99 width=4) (actual time=0.037..0.077 rows=109 loops=1)
        ->  Index Only Scan using sessions_pkey on sessions s  (cost=0.29..4.31 rows=1 width=4) (actual time=0.010..0.011 rows=1 loops=1)
              Index Cond: (id = 100)
              Heap Fetches: 0
        ->  Index Scan using tickets_session_id_seat_id_key on tickets t  (cost=0.42..181.66 rows=99 width=8) (actual time=0.024..0.050 rows=109 loops=1)
              Index Cond: (session_id = 100)
Planning Time: 0.438 ms
Execution Time: 0.151 ms

----
Прирост производительности по времени: 0.298/0.151 = 1.97 раз
Прирост производительности по стоимости: 187.46/187.45 = 1.00 разы
**/