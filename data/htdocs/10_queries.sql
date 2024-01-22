-- Фильмы на дату
EXPLAIN
SELECT f.id   as film_id,
       f.name as film_name
FROM films f
         INNER JOIN sessions s on f.id = s.film_id
WHERE s.date = '2024-01-15'
GROUP BY f.id;

/**
 * Без индекса
Group  (cost=41.52..41.55 rows=5 width=36)
  Group Key: f.id
  ->  Sort  (cost=41.52..41.53 rows=5 width=36)
        Sort Key: f.id
        ->  Hash Join  (cost=23.44..41.46 rows=5 width=36)
              Hash Cond: (f.id = s.film_id)
              ->  Seq Scan on films f  (cost=0.00..15.80 rows=580 width=36)
              ->  Hash  (cost=23.38..23.38 rows=5 width=4)
                    ->  Seq Scan on sessions s  (cost=0.00..23.38 rows=5 width=4)
                          Filter: (date = '2024-01-15'::date)

* Индекс: CREATE INDEX ON sessions(date);
Group  (cost=4.77..4.78 rows=1 width=11)
  Group Key: f.id
  ->  Sort  (cost=4.77..4.77 rows=1 width=11)
        Sort Key: f.id
        ->  Hash Join  (cost=2.38..4.76 rows=1 width=11)
              Hash Cond: (f.id = s.film_id)
              ->  Seq Scan on films f  (cost=0.00..2.00 rows=100 width=11)
              ->  Hash  (cost=2.36..2.36 rows=1 width=4)
                    ->  Seq Scan on sessions s  (cost=0.00..2.36 rows=1 width=4)
                          Filter: (date = '2024-01-15'::date)
----
Прирост производительности: 41.55/4.78 = 8.69 раз
**/

-- Фильмы за неделю
EXPLAIN
SELECT f.id   as film_id,
       f.name as film_name
FROM films f
         INNER JOIN sessions s on f.id = s.film_id
WHERE s.date BETWEEN '2024-01-20' AND '2024-01-24'
GROUP BY f.id;

/**
 * Без индекса
Group  (cost=44.20..44.22 rows=5 width=36)
  Group Key: f.id
  ->  Sort  (cost=44.20..44.21 rows=5 width=36)
        Sort Key: f.id
        ->  Hash Join  (cost=26.11..44.14 rows=5 width=36)
              Hash Cond: (f.id = s.film_id)
              ->  Seq Scan on films f  (cost=0.00..15.80 rows=580 width=36)
              ->  Hash  (cost=26.05..26.05 rows=5 width=4)
                    ->  Seq Scan on sessions s  (cost=0.00..26.05 rows=5 width=4)
                          Filter: ((date >= '2024-01-20'::date) AND (date <= '2024-01-24'::date))

  * Индекс: CREATE INDEX ON sessions(date);
Group  (cost=5.04..5.05 rows=1 width=11)
  Group Key: f.id
  ->  Sort  (cost=5.04..5.05 rows=1 width=11)
        Sort Key: f.id
        ->  Hash Join  (cost=2.65..5.03 rows=1 width=11)
              Hash Cond: (f.id = s.film_id)
              ->  Seq Scan on films f  (cost=0.00..2.00 rows=100 width=11)
              ->  Hash  (cost=2.63..2.63 rows=1 width=4)
                    ->  Seq Scan on sessions s  (cost=0.00..2.63 rows=1 width=4)
                          Filter: ((date >= '2024-01-20'::date) AND (date <= '2024-01-24'::date))
----
Прирост производительности: 44.22/5.05 = 8.76 раз
**/

-- Схема зала на сеанс
EXPLAIN
SELECT s.id            as session_id,
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
Nested Loop Left Join  (cost=3.09..19.68 rows=2 width=27)
  ->  Nested Loop Left Join  (cost=2.80..18.67 rows=2 width=23)
        ->  Nested Loop Left Join  (cost=2.53..12.83 rows=1 width=15)
              ->  Hash Right Join  (cost=2.38..4.65 rows=1 width=15)
                    Hash Cond: (f.id = s.film_id)
                    ->  Seq Scan on films f  (cost=0.00..2.00 rows=100 width=11)
                    ->  Hash  (cost=2.36..2.36 rows=1 width=12)
                          ->  Seq Scan on sessions s  (cost=0.00..2.36 rows=1 width=12)
                                Filter: (id = 100)
              ->  Index Only Scan using halls_id_key on halls h  (cost=0.15..8.17 rows=1 width=4)
                    Index Cond: (id = s.hall_id)
        ->  Index Scan using seats_hall_id_row_number_place_number_key on seats se  (cost=0.28..3.84 rows=200 width=16)
              Index Cond: (hall_id = h.id)
  ->  Index Scan using tickets_session_id_seat_id_key on tickets t  (cost=0.29..0.49 rows=1 width=12)
        Index Cond: ((session_id = 100) AND (seat_id = se.id))


  * Индекс: CREATE INDEX ON tickets USING btree(sale_price);
  Nested Loop Left Join  (cost=3.09..19.68 rows=2 width=27)
  ->  Nested Loop Left Join  (cost=2.80..18.67 rows=2 width=23)
        ->  Nested Loop Left Join  (cost=2.53..12.83 rows=1 width=15)
              ->  Hash Right Join  (cost=2.38..4.65 rows=1 width=15)
                    Hash Cond: (f.id = s.film_id)
                    ->  Seq Scan on films f  (cost=0.00..2.00 rows=100 width=11)
                    ->  Hash  (cost=2.36..2.36 rows=1 width=12)
                          ->  Seq Scan on sessions s  (cost=0.00..2.36 rows=1 width=12)
                                Filter: (id = 100)
              ->  Index Only Scan using halls_id_key on halls h  (cost=0.15..8.17 rows=1 width=4)
                    Index Cond: (id = s.hall_id)
        ->  Index Scan using seats_hall_id_row_number_place_number_key on seats se  (cost=0.28..3.84 rows=200 width=16)
              Index Cond: (hall_id = h.id)
  ->  Index Scan using tickets_session_id_seat_id_key on tickets t  (cost=0.29..0.49 rows=1 width=12)
        Index Cond: ((session_id = 100) AND (seat_id = se.id))
----
Прирост производительности: 19.68/19.68 = 1 раз (нет)
**/


-- Минимальная и максимальная стоимость билета на сеанс
EXPLAIN
SELECT MIN(t.sale_price)        as min_price,
       MAX(t.sale_price)        as max_price
FROM sessions as s
         LEFT JOIN tickets as t on t.session_id = s.id
WHERE s.id = 100;
/**
 * Без индекса - 48431.39ms

Aggregate  (cost=77.12..77.14 rows=1 width=40)
  ->  Nested Loop Left Join  (cost=5.08..76.36 rows=102 width=4)
        ->  Seq Scan on sessions s  (cost=0.00..2.36 rows=1 width=4)
              Filter: (id = 100)
        ->  Bitmap Heap Scan on tickets t  (cost=5.08..72.97 rows=102 width=8)
              Recheck Cond: (session_id = 100)
              ->  Bitmap Index Scan on tickets_session_id_seat_id_key  (cost=0.00..5.05 rows=102 width=0)
                    Index Cond: (session_id = 100)
  * С индексами:
    CREATE INDEX ON sessions(date);
    CREATE INDEX ON tickets(sale_price);
  CREATE INDEX ON sessions(id);

  Aggregate  (cost=77.12..77.14 rows=1 width=40)
  ->  Nested Loop Left Join  (cost=5.08..76.36 rows=102 width=4)
        ->  Seq Scan on sessions s  (cost=0.00..2.36 rows=1 width=4)
              Filter: (id = 100)
        ->  Bitmap Heap Scan on tickets t  (cost=5.08..72.97 rows=102 width=8)
              Recheck Cond: (session_id = 100)
              ->  Bitmap Index Scan on tickets_session_id_seat_id_key  (cost=0.00..5.05 rows=102 width=0)
                    Index Cond: (session_id = 100)

**/

