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
----------------------------------------------------------------------------------------
 Bitmap Heap Scan on screenings  (cost=58.75..8199.32 rows=4945 width=43)
   Recheck Cond: (date(start_at) = CURRENT_DATE)
   ->  Bitmap Index Scan on screenings_start_date  (cost=0.00..57.52 rows=4945 width=0)
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
---------------------------------------------------------------------------------------------------
 Aggregate  (cost=923.03..923.04 rows=1 width=8)
   ->  Index Only Scan using tickets_created_at on tickets  (cost=0.43..824.20 rows=39530 width=0)
         Index Cond: (created_at <= (CURRENT_TIMESTAMP + '7 days'::interval))
(3 rows)

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
-------------------------------------------------------------------------------------------
 Aggregate  (cost=193.32..193.33 rows=1 width=64)
   ->  Bitmap Heap Scan on visitors  (cost=4.81..193.07 rows=50 width=5)
         Recheck Cond: (screening_id = 1)
         ->  Bitmap Index Scan on visitors_screening_id  (cost=0.00..4.80 rows=50 width=0)
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
----------------------------------------------------------------------------------------------------------
 Nested Loop  (cost=1059.34..21698.62 rows=4945 width=33)
   ->  Gather  (cost=1059.18..21574.33 rows=4945 width=33)
         Workers Planned: 2
         ->  Nested Loop  (cost=59.18..20079.83 rows=2060 width=33)
               ->  Parallel Bitmap Heap Scan on screenings  (cost=58.75..8148.84 rows=2060 width=12)
                     Recheck Cond: (date(start_at) = CURRENT_DATE)
                     ->  Bitmap Index Scan on screenings_start_date  (cost=0.00..57.52 rows=4945 width=0)
                           Index Cond: (date(start_at) = CURRENT_DATE)
               ->  Index Scan using films_pkey on films  (cost=0.42..5.79 rows=1 width=29)
                     Index Cond: (id = screenings.film_id)
   ->  Memoize  (cost=0.16..0.19 rows=1 width=4)
         Cache Key: screenings.hall_id
         Cache Mode: logical
         ->  Index Only Scan using halls_pkey on halls  (cost=0.15..0.18 rows=1 width=4)
               Index Cond: (id = screenings.hall_id)
(15 rows)

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
mydb=# EXPLAIN SELECT screenings.film_id, SUM(visitors.price) AS total_money
FROM visitors
INNER JOIN screenings
    ON screenings.id = visitors.screening_id
GROUP BY screenings.film_id
ORDER BY total_money DESC
LIMIT 3;
                                                   QUERY PLAN
----------------------------------------------------------------------------------------------------------------
 Limit  (cost=145757.29..145757.29 rows=3 width=36)
   ->  Sort  (cost=145757.29..147701.61 rows=777730 width=36)
         Sort Key: (sum(visitors.price)) DESC
         ->  HashAggregate  (cost=116218.02..135705.27 rows=777730 width=36)
               Group Key: screenings.film_id
               Planned Partitions: 32
               ->  Nested Loop  (cost=0.43..52155.52 rows=1000000 width=9)
                     ->  Seq Scan on visitors  (cost=0.00..17353.00 rows=1000000 width=9)
                     ->  Memoize  (cost=0.43..0.50 rows=1 width=8)
                           Cache Key: visitors.screening_id
                           Cache Mode: logical
                           ->  Index Scan using screenings_pkey on screenings  (cost=0.42..0.49 rows=1 width=8)
                                 Index Cond: (id = visitors.screening_id)
 JIT:
   Functions: 13
   Options: Inlining false, Optimization false, Expressions true, Deforming true
(16 rows)

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
----------------------------------------------------------------------------------------------------------------------------------------
 Merge Left Join  (cost=13972.56..13984.82 rows=1000 width=5)
   Merge Cond: ((generate_series(1, (halls.amount_of_seats)::integer)) = tickets.seat)
   ->  Sort  (cost=71.46..73.96 rows=1000 width=4)
         Sort Key: (generate_series(1, (halls.amount_of_seats)::integer))
         ->  ProjectSet  (cost=0.58..21.63 rows=1000 width=4)
               ->  Nested Loop  (cost=0.58..16.62 rows=1 width=2)
                     ->  Index Scan using screenings_pkey on screenings  (cost=0.42..8.44 rows=1 width=4)
                           Index Cond: (id = 5836)
                     ->  Index Scan using halls_pkey on halls  (cost=0.15..8.17 rows=1 width=6)
                           Index Cond: (id = screenings.hall_id)
   ->  Unique  (cost=13901.10..13906.16 rows=42 width=2)
         ->  Gather Merge  (cost=13901.10..13906.05 rows=42 width=2)
               Workers Planned: 2
               ->  Unique  (cost=12901.07..12901.18 rows=21 width=2)
                     ->  Sort  (cost=12901.07..12901.13 rows=21 width=2)
                           Sort Key: tickets.seat
                           ->  Nested Loop  (cost=194.12..12900.61 rows=21 width=2)
                                 ->  Hash Join  (cost=193.69..12807.11 rows=21 width=6)
                                       Hash Cond: (tickets.visitor_id = visitors.id)
                                       ->  Parallel Seq Scan on tickets  (cost=0.00..11519.67 rows=416667 width=6)
                                       ->  Hash  (cost=193.07..193.07 rows=50 width=8)
                                             ->  Bitmap Heap Scan on visitors  (cost=4.81..193.07 rows=50 width=8)
                                                   Recheck Cond: (screening_id = 5836)
                                                   ->  Bitmap Index Scan on visitors_screening_id  (cost=0.00..4.80 rows=50 width=0)
                                                         Index Cond: (screening_id = 5836)
                                 ->  Index Only Scan using screenings_pkey on screenings screenings_1  (cost=0.42..4.44 rows=1 width=4)
                                       Index Cond: (id = 5836)
(27 rows)

 */

