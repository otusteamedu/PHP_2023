/** Simple query: get all screenings for today */

/* QUERY: */
SELECT *
FROM screenings
WHERE DATE (start_at) = CURRENT_DATE;

/*
EXPLAIN:

mydb=# EXPLAIN SELECT *
FROM screenings
WHERE DATE (start_at) = CURRENT_DATE;
                          QUERY PLAN
--------------------------------------------------------------
 Seq Scan on screenings  (cost=0.00..269.00 rows=50 width=43)
   Filter: (date(start_at) = CURRENT_DATE)
(2 rows)

POSSIBLE INDEX:

CREATE INDEX screenings_start_date ON screenings USING BTREE ((DATE(start_at)));

EXPLAIN AFTER INDEX:

mydb=# EXPLAIN SELECT *
FROM screenings
WHERE DATE (start_at) = CURRENT_DATE;
                                     QUERY PLAN
-------------------------------------------------------------------------------------
 Bitmap Heap Scan on screenings  (cost=4.68..87.27 rows=50 width=43)
   Recheck Cond: (date(start_at) = CURRENT_DATE)
   ->  Bitmap Index Scan on screenings_start_date  (cost=0.00..4.66 rows=50 width=0)
         Index Cond: (date(start_at) = CURRENT_DATE)
*/

/** ==================================================== */

/** Simple query: sold tickets for one week */

/* QUERY: */
SELECT COUNT(*)
FROM tickets
WHERE created_at <= CURRENT_TIMESTAMP + INTERVAL '7 DAYS';

/*
EXPLAIN:

mydb=# EXPLAIN SELECT COUNT(*)
FROM tickets
WHERE created_at <= CURRENT_TIMESTAMP + INTERVAL '7 DAYS';
                                QUERY PLAN
--------------------------------------------------------------------------
 Aggregate  (cost=250.08..250.09 rows=1 width=8)
   ->  Seq Scan on tickets  (cost=0.00..249.00 rows=432 width=0)
         Filter: (created_at <= (CURRENT_TIMESTAMP + '7 days'::interval))

POSSIBLE INDEX:

CREATE INDEX tickets_created_at ON tickets (created_at);

EXPLAIN AFTER INDEX:

mydb=# EXPLAIN SELECT COUNT(*)
FROM tickets
WHERE created_at <= CURRENT_TIMESTAMP + INTERVAL '7 DAYS';
                                           QUERY PLAN
------------------------------------------------------------------------------------------------
 Aggregate  (cost=12.93..12.94 rows=1 width=8)
   ->  Index Only Scan using tickets_created_at on tickets  (cost=0.29..11.85 rows=432 width=0)
         Index Cond: (created_at <= (CURRENT_TIMESTAMP + '7 days'::interval))
 */

/** ==================================================== */

/** Simple query: get min and max price for tickers */

/* QUERY: */
SELECT MIN(price), MAX(price)
FROM visitors
WHERE screening_id = 1;

/*
EXPLAIN:

mydb=# EXPLAIN SELECT MIN(price), MAX(price)
FROM visitors
WHERE screening_id = 1;
                           QUERY PLAN
-----------------------------------------------------------------
 Aggregate  (cost=199.25..199.26 rows=1 width=64)
   ->  Seq Scan on visitors  (cost=0.00..199.00 rows=50 width=5)
         Filter: (screening_id = 1)

POSSIBLE INDEX:

CREATE INDEX visitors_screening_id ON visitors (screening_id);

EXPLAIN AFTER INDEX:

mydb=# EXPLAIN SELECT MIN(price), MAX(price)
FROM visitors
WHERE screening_id = 1;
                                        QUERY PLAN
-------------------------------------------------------------------------------------------
 Aggregate  (cost=75.86..75.87 rows=1 width=64)
   ->  Bitmap Heap Scan on visitors  (cost=4.67..75.61 rows=50 width=5)
         Recheck Cond: (screening_id = 1)
         ->  Bitmap Index Scan on visitors_screening_id  (cost=0.00..4.66 rows=50 width=0)
               Index Cond: (screening_id = 1)
 */

/** ==================================================== */

/** Hard query: get all screenings for today with film name and hall name */

/* QUERY: */
SELECT screenings.id, films.name, halls.id AS hall
FROM screenings
INNER JOIN films
    ON films.id = screenings.film_id
INNER JOIN halls
    ON halls.id = screenings.hall_id
WHERE DATE (start_at) = CURRENT_DATE;

/*
EXPLAIN:

mydb=# EXPLAIN SELECT screenings.id, films.name, halls.id AS hall
FROM screenings
INNER JOIN films
    ON films.id = screenings.film_id
INNER JOIN halls
    ON halls.id = screenings.hall_id
WHERE DATE (start_at) = CURRENT_DATE;
                                              QUERY PLAN
-------------------------------------------------------------------------------------------------------
 Nested Loop  (cost=88.06..351.09 rows=50 width=33)
   ->  Hash Join  (cost=87.90..345.40 rows=50 width=33)
         Hash Cond: (films.id = screenings.film_id)
         ->  Seq Scan on films  (cost=0.00..207.00 rows=10000 width=29)
         ->  Hash  (cost=87.27..87.27 rows=50 width=12)
               ->  Bitmap Heap Scan on screenings  (cost=4.68..87.27 rows=50 width=12)
                     Recheck Cond: (date(start_at) = CURRENT_DATE)
                     ->  Bitmap Index Scan on screenings_start_date  (cost=0.00..4.66 rows=50 width=0)
                           Index Cond: (date(start_at) = CURRENT_DATE)
   ->  Memoize  (cost=0.16..1.14 rows=1 width=4)
         Cache Key: screenings.hall_id
         Cache Mode: logical
         ->  Index Only Scan using halls_pkey on halls  (cost=0.15..1.13 rows=1 width=4)
               Index Cond: (id = screenings.hall_id)

POSSIBLE INDEX:

NOT NEEDED. Already exists screenings_start_date index.

 */

/** ==================================================== */

/** Hard query: get most popular films */

/* QUERY: */
SELECT screenings.film_id, SUM(visitors.price) AS total_money
FROM visitors
INNER JOIN screenings
    ON screenings.id = visitors.screening_id
GROUP BY screenings.film_id
ORDER BY total_money DESC
LIMIT 3;

/*
EXPLAIN:

mydb=# EXPLAIN SELECT screenings.film_id, SUM(visitors.price) AS total_money
FROM visitors
INNER JOIN screenings
    ON screenings.id = visitors.screening_id
GROUP BY screenings.film_id
ORDER BY total_money DESC
LIMIT 3;
                                                   QUERY PLAN
----------------------------------------------------------------------------------------------------------------
 Limit  (cost=767.24..767.24 rows=3 width=36)
   ->  Sort  (cost=767.24..789.11 rows=8751 width=36)
         Sort Key: (sum(visitors.price)) DESC
         ->  HashAggregate  (cost=544.74..654.13 rows=8751 width=36)
               Group Key: screenings.film_id
               ->  Nested Loop  (cost=0.30..494.74 rows=10000 width=9)
                     ->  Seq Scan on visitors  (cost=0.00..174.00 rows=10000 width=9)
                     ->  Memoize  (cost=0.30..0.36 rows=1 width=8)
                           Cache Key: visitors.screening_id
                           Cache Mode: logical
                           ->  Index Scan using screenings_pkey on screenings  (cost=0.29..0.35 rows=1 width=8)
                                 Index Cond: (id = visitors.screening_id)

POSSIBLE INDEX:

NOT NEEDED; Already exists screenings_pkey index.

 */

/** ==================================================== */

/** Hard query: get hall seats schema */

/* QUERY: */
SELECT available_seats.available_seat AS seat, sold_seats.seat IS NOT NULL AS is_sold
FROM (
         SELECT generate_series(1, halls.amount_of_seats) AS available_seat
         FROM screenings
         INNER JOIN halls
            ON halls.id = screenings.hall_id
         WHERE screenings.id = 5836
     ) AS available_seats
LEFT JOIN (
    SELECT DISTINCT tickets.seat
    FROM tickets
    INNER JOIN visitors
       ON visitors.id = tickets.visitor_id
    INNER JOIN screenings
       ON screenings.id = visitors.screening_id
    WHERE screenings.id = 5836
    ORDER BY tickets.seat
) AS sold_seats
    ON available_seats.available_seat = sold_seats.seat
ORDER BY available_seats.available_seat;

/*
EXPLAIN:

mydb=# EXPLAIN SELECT available_seats.available_seat AS seat, sold_seats.seat IS NOT NULL AS is_sold
FROM (
         SELECT generate_series(1, halls.amount_of_seats) AS available_seat
         FROM screenings
         INNER JOIN halls
            ON halls.id = screenings.hall_id
         WHERE screenings.id = 5836
     ) AS available_seats
LEFT JOIN (
    SELECT DISTINCT tickets.seat
    FROM tickets
             INNER JOIN visitors
                        ON visitors.id = tickets.visitor_id
             INNER JOIN screenings
                        ON screenings.id = visitors.screening_id
    WHERE screenings.id = 5836
    ORDER BY tickets.seat
) AS sold_seats
    ON available_seats.available_seat = sold_seats.seat
ORDER BY available_seats.available_seat;
                                                         QUERY PLAN
----------------------------------------------------------------------------------------------------------------------------
 Merge Left Join  (cost=354.03..361.90 rows=1000 width=5)
   Merge Cond: ((generate_series(1, (halls.amount_of_seats)::integer)) = tickets.seat)
   ->  Sort  (cost=71.32..73.82 rows=1000 width=4)
         Sort Key: (generate_series(1, (halls.amount_of_seats)::integer))
         ->  ProjectSet  (cost=0.44..21.49 rows=1000 width=4)
               ->  Nested Loop  (cost=0.44..16.48 rows=1 width=2)
                     ->  Index Scan using screenings_pkey on screenings  (cost=0.29..8.30 rows=1 width=4)
                           Index Cond: (id = 5836)
                     ->  Index Scan using halls_pkey on halls  (cost=0.15..8.17 rows=1 width=6)
                           Index Cond: (id = screenings.hall_id)
   ->  Unique  (cost=282.70..282.95 rows=50 width=2)
         ->  Sort  (cost=282.70..282.83 rows=50 width=2)
               Sort Key: tickets.seat
               ->  Nested Loop  (cost=76.52..281.29 rows=50 width=2)
                     ->  Index Only Scan using screenings_pkey on screenings screenings_1  (cost=0.29..4.30 rows=1 width=4)
                           Index Cond: (id = 5836)
                     ->  Hash Join  (cost=76.23..276.49 rows=50 width=6)
                           Hash Cond: (tickets.visitor_id = visitors.id)
                           ->  Seq Scan on tickets  (cost=0.00..174.00 rows=10000 width=6)
                           ->  Hash  (cost=75.61..75.61 rows=50 width=8)
                                 ->  Bitmap Heap Scan on visitors  (cost=4.67..75.61 rows=50 width=8)
                                       Recheck Cond: (screening_id = 5836)
                                       ->  Bitmap Index Scan on visitors_screening_id  (cost=0.00..4.66 rows=50 width=0)
                                             Index Cond: (screening_id = 5836)

POSSIBLE INDEX:

NOT NEEDED;
 */

