# PHP_2023

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus


-----
# Выбор всех фильмов на сегодня
```sql    
    SELECT DISTINCT title
    FROM "movies" LEFT JOIN  session
    ON movies.id=session.movie_id
    WHERE session.datetime = (now()::date)
```

### Малое кол-во данных

```sql  
    QUERY PLAN
    HashAggregate (cost=243.97..245.97 rows=200 width=14)
    Group Key: movies.title
    -> Nested Loop (cost=0.29..243.47 rows=200 width=14)
    -> Seq Scan on session (cost=0.00..212.50 rows=200 width=8)
    Filter: (datetime = (now())::date)
    -> Memoize (cost=0.29..0.66 rows=1 width=22)
    Cache Key: session.movie_id
    Cache Mode: logical
    -> Index Scan using movies_pkey on movies (cost=0.28..0.65 rows=1 width=22)
    Index Cond: (id = session.movie_id)
```

### Большое кол-во данных
```sql  
    QUERY PLAN
    Unique (cost=127195.91..127216.56 rows=4130 width=17)
    -> Sort (cost=127195.91..127206.23 rows=4130 width=17)
    Sort Key: movies.title
    -> Gather (cost=126514.21..126947.86 rows=4130 width=17)
    Workers Planned: 2
    -> HashAggregate (cost=125514.21..125534.86 rows=2065 width=17)
    Group Key: movies.title
    -> Nested Loop (cost=0.43..125509.05 rows=2065 width=17)
    -> Parallel Seq Scan on session (cost=0.00..119583.81 rows=2065 width=8)
    Filter: (datetime = (now())::date)
    -> Memoize (cost=0.43..5.93 rows=1 width=25)
    Cache Key: session.movie_id
    Cache Mode: logical
    -> Index Scan using movies_pkey on movies (cost=0.42..5.92 rows=1 width=25)
    Index Cond: (id = session.movie_id)
    JIT:
    Functions: 14
    Options: Inlining false, Optimization false, Expressions true, Deforming
```
### После добавления индекса по полю  datetime
```sql     
QUERY PLAN
    HashAggregate (cost=21955.22..22004.85 rows=4963 width=17)
    Group Key: movies.title
    -> Nested Loop (cost=59.34..21942.81 rows=4963 width=17)
    -> Bitmap Heap Scan on session (cost=58.90..15945.53 rows=4963 width=8)
    Recheck Cond: (datetime = (now())::date)
    -> Bitmap Index Scan on session_datetime (cost=0.00..57.66 rows=4963 width=0)
    Index Cond: (datetime = (now())::date)
    -> Memoize (cost=0.43..5.93 rows=1 width=25)
    Cache Key: session.movie_id
    Cache Mode: logical
    -> Index Scan using movies_pkey on movies (cost=0.42..5.92 rows=1 width=25)
    Index Cond: (id = session.movie_id)
```

-----
# Подсчёт проданных билетов за неделю
```sql  
    SELECT count(tickets.id)
    FROM session LEFT JOIN tickets
    ON session.id= tickets.session_id
    LEFT JOIN basket_item
    ON tickets.id = basket_item.tickets_id
    LEFT JOIN orders
    ON basket_item.orders_id = orders.id
    WHERE session.datetime<(now()::date) AND session.datetime>((now()::date)-8) AND orders.pay = true
```
### Малое кол-во данных
```sql  
    QUERY PLAN
    Finalize Aggregate (cost=17427.24..17427.25 rows=1 width=8)
    -> Gather (cost=17427.13..17427.24 rows=1 width=8)
    Workers Planned: 1
    -> Partial Aggregate (cost=16427.13..16427.14 rows=1 width=8)
    -> Parallel Hash Join (cost=10202.81..16364.17 rows=25184 width=8)
    Hash Cond: (orders.id = basket_item.orders_id)
    -> Parallel Seq Scan on orders (cost=0.00..5370.12 rows=171494 width=8)
    Filter: pay
    -> Parallel Hash (cost=9753.61..9753.61 rows=35936 width=16)
    -> Parallel Hash Join (cost=5756.51..9753.61 rows=35936 width=16)
    Hash Cond: (basket_item.tickets_id = tickets.id)
    -> Parallel Seq Scan on basket_item (cost=0.00..3208.15 rows=154015 width=16)
    -> Parallel Hash (cost=5139.25..5139.25 rows=49381 width=8)
    -> Hash Join (cost=174.88..5139.25 rows=49381 width=8)
    Hash Cond: (tickets.session_id = session.id)
    -> Parallel Seq Scan on tickets (cost=0.00..4408.32 rows=211632 width=16)
    -> Hash (cost=161.75..161.75 rows=1050 width=8)
    -> Seq Scan on session (cost=0.00..161.75 rows=1050 width=8)
    Filter: ((datetime >= (now())::date) AND (datetime < ((now())::date + 7)))
```
### Большое кол-во данных
```sql  
    QUERY PLAN
    Finalize Aggregate (cost=42456.93..42456.94 rows=1 width=8)
    -> Gather (cost=42456.71..42456.92 rows=2 width=8)
    Workers Planned: 2
    -> Partial Aggregate (cost=41456.71..41456.72 rows=1 width=8)
    -> Nested Loop (cost=1.29..41452.28 rows=1772 width=8)
    -> Nested Loop (cost=0.87..40218.83 rows=2530 width=16)
    -> Nested Loop (cost=0.44..38993.67 rows=2530 width=8)
    -> Parallel Seq Scan on tickets (cost=0.00..10536.67 rows=416667 width=16)
    -> Memoize (cost=0.44..0.92 rows=1 width=8)
    Cache Key: tickets.session_id
    Cache Mode: logical
    -> Index Scan using session_pkey on session (cost=0.43..0.91 rows=1 width=8)
    Index Cond: (id = tickets.session_id)
    Filter: ((datetime < (now())::date) AND (datetime > ((now())::date - 8)))
    -> Index Scan using basket_item_tickets_id_key on basket_item (cost=0.42..0.48 rows=1 width=16)
    Index Cond: (tickets_id = tickets.id)
    -> Index Scan using orders_pkey on orders (cost=0.42..0.49 rows=1 width=8)
    Index Cond: (id = basket_item.orders_id)
    Filter: pay
```
### После добавления индекса по полю  session.datetime
```sql  
    QUERY PLAN
    Finalize Aggregate (cost=42456.93..42456.94 rows=1 width=8)
    -> Gather (cost=42456.71..42456.92 rows=2 width=8)
    Workers Planned: 2
    -> Partial Aggregate (cost=41456.71..41456.72 rows=1 width=8)
    -> Nested Loop (cost=1.29..41452.28 rows=1772 width=8)
    -> Nested Loop (cost=0.87..40218.83 rows=2530 width=16)
    -> Nested Loop (cost=0.44..38993.67 rows=2530 width=8)
    -> Parallel Seq Scan on tickets (cost=0.00..10536.67 rows=416667 width=16)
    -> Memoize (cost=0.44..0.92 rows=1 width=8)
    Cache Key: tickets.session_id
    Cache Mode: logical
    -> Index Scan using session_pkey on session (cost=0.43..0.91 rows=1 width=8)
    Index Cond: (id = tickets.session_id)
    Filter: ((datetime < (now())::date) AND (datetime > ((now())::date - 8)))
    -> Index Scan using basket_item_tickets_id_key on basket_item (cost=0.42..0.48 rows=1 width=16)
    Index Cond: (tickets_id = tickets.id)
    -> Index Scan using orders_pkey on orders (cost=0.42..0.49 rows=1 width=8)
    Index Cond: (id = basket_item.orders_id)
    Filter: pay
```
### После добавления индекса по полю orders.pay и tickets.session_id и basket_item.tickets_id сиутацию не изменили.
Изменил структуру таблицы orders, добавил в нее даты покупку
```sql  
    SELECT count(basket_item.tickets_id)
    FROM orders
    RIGHT JOIN basket_item
    ON orders.id =basket_item.orders_id
    WHERE orders.date_pay<(now()::date) AND orders.date_pay>((now()::date)-8) AND orders.pay = true
```

```sql  
    QUERY PLAN
    Finalize Aggregate (cost=19715.99..19716.00 rows=1 width=8)
    -> Gather (cost=19715.77..19715.98 rows=2 width=8)
    Workers Planned: 2
    -> Partial Aggregate (cost=18715.77..18715.78 rows=1 width=8)
    -> Nested Loop (cost=107.71..18710.11 rows=2266 width=8)
    -> Parallel Bitmap Heap Scan on orders (cost=107.29..7541.22 rows=2266 width=8)
    Recheck Cond: ((date_pay < (now())::date) AND (date_pay > ((now())::date - 8)))
    Filter: pay
    -> Bitmap Index Scan on orders_date_pay (cost=0.00..105.93 rows=7749 width=0)
    Index Cond: ((date_pay < (now())::date) AND (date_pay > ((now())::date - 8)))
    -> Index Scan using basket_item_orders_id on basket_item (cost=0.42..4.90 rows=3 width=16)
    Index Cond: (orders_id = orders.id) 
```


---
# Формирование афиши (фильмы, которые показывают сегодня)
```sql  
    SELECT DISTINCT title,description,duration
    FROM session LEFT JOIN movies
    ON session.movie_id = movies.id
    WHERE session.datetime>=(now()::date) AND session.datetime<((now()::date)+1)
    ORDER BY title
```
### Малое кол-во данных
```sql  
    QUERY PLAN
    Unique (cost=207.11..208.61 rows=150 width=51)
    -> Sort (cost=207.11..207.48 rows=150 width=51)
    Sort Key: movies.title, movies.description, movies.duration
    -> Nested Loop Left Join (cost=0.29..201.69 rows=150 width=51)
    -> Seq Scan on session (cost=0.00..161.75 rows=150 width=8)
    Filter: ((datetime >= (now())::date) AND (datetime < ((now())::date + 1)))
    -> Memoize (cost=0.29..1.19 rows=1 width=59)
    Cache Key: session.movie_id
    Cache Mode: logical
    -> Index Scan using movies_pkey on movies (cost=0.28..1.18 rows=1 width=59)
    Index Cond: (id = session.movie_id)
```
### Большое кол-во данных
```sql  
    QUERY PLAN
    Unique (cost=147942.45..147987.85 rows=4540 width=57)
    -> Sort (cost=147942.45..147953.80 rows=4540 width=57)
    Sort Key: movies.title, movies.description, movies.duration
    -> Gather (cost=147189.98..147666.68 rows=4540 width=57)
    Workers Planned: 2
    -> HashAggregate (cost=146189.98..146212.68 rows=2270 width=57)
    Group Key: movies.title, movies.description, movies.duration
    -> Nested Loop Left Join (cost=0.43..146172.95 rows=2270 width=57)
    -> Parallel Seq Scan on session (cost=0.00..140369.42 rows=2270 width=8)
    Filter: ((datetime >= (now())::date) AND (datetime < ((now())::date + 1)))
    -> Memoize (cost=0.43..5.78 rows=1 width=65)
    Cache Key: session.movie_id
    Cache Mode: logical
    -> Index Scan using movies_pkey on movies (cost=0.42..5.77 rows=1 width=65)
    Index Cond: (id = session.movie_id)
    JIT:
    Functions: 14
    Options: Inlining false, Optimization false, Expressions true, Deforming true
```

### После добавления индексов на предыдущих шагах
```sql  
    QUERY PLAN
    Unique (cost=23579.75..23634.29 rows=5454 width=57)
    -> Sort (cost=23579.75..23593.39 rows=5454 width=57)
    Sort Key: movies.title, movies.description, movies.duration
    -> Nested Loop Left Join (cost=76.78..23241.25 rows=5454 width=57)
    -> Bitmap Heap Scan on session (cost=76.35..17359.07 rows=5454 width=8)
    Recheck Cond: ((datetime >= (now())::date) AND (datetime < ((now())::date + 1)))
    -> Bitmap Index Scan on session_datetime (cost=0.00..74.98 rows=5454 width=0)
    Index Cond: ((datetime >= (now())::date) AND (datetime < ((now())::date + 1)))
    -> Memoize (cost=0.43..5.78 rows=1 width=65)
    Cache Key: session.movie_id
    Cache Mode: logical
    -> Index Scan using movies_pkey on movies (cost=0.42..5.77 rows=1 width=65)
    Index Cond: (id = session.movie_id)
```


---
# Поиск 3 самых прибыльных фильмов за неделю
```sql  
    SELECT movies.TITLE, ROUND(SUM(movies.price * session.koef *places.koef * halls.koef )) as sum
    FROM session LEFT JOIN tickets
    ON session.id= tickets.session_id
    LEFT JOIN basket_item
    ON tickets.id = basket_item.tickets_id
    LEFT JOIN orders
    ON basket_item.orders_id = orders.id
    LEFT JOIN movies
    ON movies.id = session.movie_id
    LEFT JOIN places
    ON places.id = tickets.place_id
    LEFT JOIN halls
    ON halls.id = session.hall_id
    WHERE session.datetime<(now()::date) AND session.datetime>=((now()::date)-7) AND orders.pay = true
    GROUP BY movies.id
    ORDER BY sum DESC
    LIMIT 3
```
### Малое кол-во данных
```sql     
QUERY PLAN
    Limit (cost=18465.87..18465.88 rows=3 width=30)
    -> Sort (cost=18465.87..18470.87 rows=2000 width=30)
    Sort Key: (round(sum(((((movies.price)::double precision * session.koef) * places.koef) * halls.koef)))) DESC
    -> Finalize GroupAggregate (cost=18175.02..18440.02 rows=2000 width=30)
    Group Key: movies.id
    -> Gather Merge (cost=18175.02..18405.02 rows=2000 width=30)
    Workers Planned: 1
    -> Sort (cost=17175.01..17180.01 rows=2000 width=30)
    Sort Key: movies.id
    -> Partial HashAggregate (cost=17045.35..17065.35 rows=2000 width=30)
    Group Key: movies.id
    -> Hash Left Join (cost=10305.21..16667.59 rows=25184 width=52)
    Hash Cond: (session.hall_id = halls.id)
    -> Hash Left Join (cost=10292.06..16586.33 rows=25184 width=52)
    Hash Cond: (tickets.place_id = places.id)
    -> Hash Left Join (cost=10272.81..16500.42 rows=25184 width=52)
    Hash Cond: (session.movie_id = movies.id)
    -> Parallel Hash Join (cost=10202.81..16364.17 rows=25184 width=32)
    Hash Cond: (orders.id = basket_item.orders_id)
    -> Parallel Seq Scan on orders (cost=0.00..5370.12 rows=171494 width=8)
    Filter: pay
    -> Parallel Hash (cost=9753.61..9753.61 rows=35936 width=40)
    -> Parallel Hash Join (cost=5756.51..9753.61 rows=35936 width=40)
    Hash Cond: (basket_item.tickets_id = tickets.id)
    -> Parallel Seq Scan on basket_item (cost=0.00..3208.15 rows=154015 width=16)
    -> Parallel Hash (cost=5139.25..5139.25 rows=49381 width=40)
    -> Hash Join (cost=174.88..5139.25 rows=49381 width=40)
    Hash Cond: (tickets.session_id = session.id)
    -> Parallel Seq Scan on tickets (cost=0.00..4408.32 rows=211632 width=24)
    -> Hash (cost=161.75..161.75 rows=1050 width=32)
    -> Seq Scan on session (cost=0.00..161.75 rows=1050 width=32)
    Filter: ((datetime >= (now())::date) AND (datetime < ((now())::date + 7)))
    -> Hash (cost=45.00..45.00 rows=2000 width=28)
    -> Seq Scan on movies (cost=0.00..45.00 rows=2000 width=28)
    -> Hash (cost=13.00..13.00 rows=500 width=16)
    -> Seq Scan on places (cost=0.00..13.00 rows=500 width=16)
    -> Hash (cost=11.40..11.40 rows=140 width=16)
    -> Seq Scan on halls (cost=0.00..11.40 rows=140 width=16)
```
### Большое кол-во данных
```sql  
    QUERY PLAN
    Limit (cost=46177.00..46177.00 rows=3 width=33)
    -> Sort (cost=46177.00..46187.82 rows=4330 width=33)
    Sort Key: (round(sum(((((movies.price)::double precision * session.koef) * places.koef) * halls.koef)))) DESC
    -> GroupAggregate (cost=45165.12..46121.03 rows=4330 width=33)
    Group Key: movies.id
    -> Nested Loop Left Join (cost=45165.12..46001.96 rows=4330 width=55)
    -> Nested Loop Left Join (cost=45164.96..45893.35 rows=4330 width=55)
    -> Gather Merge (cost=45164.68..45668.98 rows=4330 width=55)
    Workers Planned: 2
    -> Sort (cost=44164.66..44169.17 rows=1804 width=55)
    Sort Key: movies.id
    -> Nested Loop Left Join (cost=1.73..44067.09 rows=1804 width=55)
    -> Nested Loop (cost=1.29..41496.98 rows=1804 width=32)
    -> Nested Loop (cost=0.87..40241.10 rows=2576 width=40)
    -> Nested Loop (cost=0.44..38993.67 rows=2576 width=40)
    -> Parallel Seq Scan on tickets (cost=0.00..10536.67 rows=416667 width=24)
    -> Memoize (cost=0.44..0.92 rows=1 width=32)
    Cache Key: tickets.session_id
    Cache Mode: logical
    -> Index Scan using session_pkey on session (cost=0.43..0.91 rows=1 width=32)
    Index Cond: (id = tickets.session_id)
    Filter: ((datetime < (now())::date) AND (datetime >= ((now())::date - 7)))
    -> Index Scan using basket_item_tickets_id_key on basket_item (cost=0.42..0.48 rows=1 width=16)
    Index Cond: (tickets_id = tickets.id)
    -> Index Scan using orders_pkey on orders (cost=0.42..0.49 rows=1 width=8)
    Index Cond: (id = basket_item.orders_id)
    Filter: pay
    -> Memoize (cost=0.43..2.54 rows=1 width=31)
    Cache Key: session.movie_id
    Cache Mode: logical
    -> Index Scan using movies_pkey on movies (cost=0.42..2.53 rows=1 width=31)
    Index Cond: (id = session.movie_id)
    -> Memoize (cost=0.28..0.30 rows=1 width=16)
    Cache Key: tickets.place_id
    Cache Mode: logical
    -> Index Scan using places_pkey on places (cost=0.27..0.29 rows=1 width=16)
    Index Cond: (id = tickets.place_id)
    -> Memoize (cost=0.15..0.17 rows=1 width=16)
    Cache Key: session.hall_id
    Cache Mode: logical
    -> Index Scan using halls_pkey on halls (cost=0.14..0.16 rows=1 width=16)
    Index Cond: (id = session.hall_id
```
### Здесь также добавление индексов не ускорило запрос
```sql  
    QUERY PLAN
    Limit (cost=46174.30..46174.31 rows=3 width=33)
    -> Sort (cost=46174.30..46185.12 rows=4330 width=33)
    Sort Key: (round(sum(((((movies.price)::double precision * session.koef) * places.koef) * halls.koef)))) DESC
    -> GroupAggregate (cost=45162.42..46118.33 rows=4330 width=33)
    Group Key: movies.id
    -> Nested Loop Left Join (cost=45162.42..45999.26 rows=4330 width=55)
    -> Nested Loop Left Join (cost=45162.26..45890.65 rows=4330 width=55)
    -> Gather Merge (cost=45161.98..45666.28 rows=4330 width=55)
    Workers Planned: 2
    -> Sort (cost=44161.96..44166.47 rows=1804 width=55)
    Sort Key: movies.id
    -> Nested Loop Left Join (cost=1.73..44064.39 rows=1804 width=55)
    -> Nested Loop (cost=1.29..41496.98 rows=1804 width=32)
    -> Nested Loop (cost=0.87..40241.10 rows=2576 width=40)
    -> Nested Loop (cost=0.44..38993.67 rows=2576 width=40)
    -> Parallel Seq Scan on tickets (cost=0.00..10536.67 rows=416667 width=24)
    -> Memoize (cost=0.44..0.92 rows=1 width=32)
    Cache Key: tickets.session_id
    Cache Mode: logical
    -> Index Scan using session_pkey on session (cost=0.43..0.91 rows=1 width=32)
    Index Cond: (id = tickets.session_id)
    Filter: ((datetime < (now())::date) AND (datetime >= ((now())::date - 7)))
    -> Index Scan using basket_item_tickets_id_key on basket_item (cost=0.42..0.48 rows=1 width=16)
    Index Cond: (tickets_id = tickets.id)
    -> Index Scan using orders_pkey on orders (cost=0.42..0.49 rows=1 width=8)
    Index Cond: (id = basket_item.orders_id)
    Filter: pay
    -> Memoize (cost=0.43..2.53 rows=1 width=31)
    Cache Key: session.movie_id
    Cache Mode: logical
    -> Index Scan using movies_pkey on movies (cost=0.42..2.52 rows=1 width=31)
    Index Cond: (id = session.movie_id)
    -> Memoize (cost=0.28..0.30 rows=1 width=16)
    Cache Key: tickets.place_id
    Cache Mode: logical
    -> Index Scan using places_pkey on places (cost=0.27..0.29 rows=1 width=16)
    Index Cond: (id = tickets.place_id)
    -> Memoize (cost=0.15..0.17 rows=1 width=16)
    Cache Key: session.hall_id
    Cache Mode: logical
    -> Index Scan using halls_pkey on halls (cost=0.14..0.16 rows=1 width=16)
    Index Cond: (id = session.hall_id)
```

---
# Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
```sql  
    SELECT row,pay as busy
    FROM session LEFT JOIN tickets
    ON session.id= tickets.session_id
    LEFT JOIN basket_item
    ON tickets.id = basket_item.tickets_id
    LEFT JOIN orders
    ON basket_item.orders_id = orders.id
    LEFT JOIN places
    ON places.id = tickets.place_id
    WHERE session.id = 2001
    ORDER BY row,place
```
### Малое кол-во данных
```sql  
    QUERY PLAN
    Sort (cost=5960.36..5960.36 rows=1 width=9)
    Sort Key: places."row", places.place
    -> Nested Loop Left Join (cost=1001.40..5960.35 rows=1 width=9)
    -> Nested Loop Left Join (cost=1001.12..5959.40 rows=1 width=9)
    -> Nested Loop Left Join (cost=1000.70..5958.88 rows=1 width=16)
    -> Nested Loop Left Join (cost=1000.28..5950.70 rows=1 width=16)
    Join Filter: (session.id = tickets.session_id)
    -> Index Only Scan using session_pkey on session (cost=0.28..4.30 rows=1 width=8)
    Index Cond: (id = 2001)
    -> Gather (cost=1000.00..5945.40 rows=80 width=24)
    Workers Planned: 1
    -> Parallel Seq Scan on tickets (cost=0.00..4937.40 rows=47 width=24)
    Filter: (session_id = 2001)
    -> Index Scan using basket_item_tickets_id_key on basket_item (cost=0.42..8.19 rows=1 width=16)
    Index Cond: (tickets_id = tickets.id)
    -> Index Scan using orders_pkey on orders (cost=0.42..0.52 rows=1 width=9)
    Index Cond: (id = basket_item.orders_id)
    -> Index Scan using places_pkey on places (cost=0.27..0.94 rows=1 width=16)
    Index Cond: (id = tickets.place_id)
```
### Большое кол-во данных
```sql  
    QUERY PLAN
    Sort (cost=12602.28..12602.29 rows=1 width=9)
    Sort Key: places."row", places.place
    -> Nested Loop Left Join (cost=1001.55..12602.27 rows=1 width=9)
    -> Nested Loop Left Join (cost=1001.28..12601.34 rows=1 width=9)
    -> Nested Loop Left Join (cost=1000.86..12600.85 rows=1 width=16)
    -> Nested Loop Left Join (cost=1000.43..12592.41 rows=1 width=16)
    Join Filter: (session.id = tickets.session_id)
    -> Index Only Scan using session_pkey on session (cost=0.43..8.45 rows=1 width=8)
    Index Cond: (id = 20074907)
    -> Gather (cost=1000.00..12583.33 rows=50 width=24)
    Workers Planned: 2
    -> Parallel Seq Scan on tickets (cost=0.00..11578.33 rows=21 width=24)
    Filter: (session_id = 20074907)
    -> Index Scan using basket_item_tickets_id_key on basket_item (cost=0.42..8.44 rows=1 width=16)
    Index Cond: (tickets_id = tickets.id)
    -> Index Scan using orders_pkey on orders (cost=0.42..0.49 rows=1 width=9)
    Index Cond: (id = basket_item.orders_id)
    -> Index Scan using places_pkey on places (cost=0.27..0.93 rows=1 width=16)
    Index Cond: (id = tickets.place_id)
```
### После добавления индексов на предыдущих шагах
```sql  
    QUERY PLAN
    Sort (cost=114.00..114.00 rows=1 width=9)
    Sort Key: places."row", places.place
    -> Nested Loop Left Join (cost=1.98..113.99 rows=1 width=9)
    -> Nested Loop Left Join (cost=1.71..113.06 rows=1 width=9)
    -> Nested Loop Left Join (cost=1.28..112.57 rows=1 width=16)
    -> Nested Loop Left Join (cost=0.86..104.12 rows=1 width=16)
    Join Filter: (session.id = tickets.session_id)
    -> Index Only Scan using session_pkey on session (cost=0.43..8.45 rows=1 width=8)
    Index Cond: (id = 20074907)
    -> Index Scan using tickets_session_id_place_id on tickets (cost=0.42..95.05 rows=50 width=24)
    Index Cond: (session_id = 20074907)
    -> Index Scan using basket_item_tickets_id_key on basket_item (cost=0.42..8.44 rows=1 width=16)
    Index Cond: (tickets_id = tickets.id)
    -> Index Scan using orders_pkey on orders (cost=0.42..0.49 rows=1 width=9)
    Index Cond: (id = basket_item.orders_id)
    -> Index Scan using places_pkey on places (cost=0.27..0.93 rows=1 width=16)
    Index Cond: (id = tickets.place_id)
```

---
# Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс
```sql  
    SELECT MAX(priceTicket) as maxPrice, MIN(priceTicket) as minPrice
    FROM
    ( SELECT ROUND(movies.price * session.koef *places.koef * halls.koef ) as priceTicket
    FROM session LEFT JOIN tickets
    ON session.id= tickets.session_id
    LEFT JOIN basket_item
    ON tickets.id = basket_item.tickets_id
    LEFT JOIN orders
    ON basket_item.orders_id = orders.id
    LEFT JOIN movies
    ON movies.id = session.movie_id
    LEFT JOIN places
    ON places.id = tickets.place_id
    LEFT JOIN halls
    ON halls.id = session.hall_id
    WHERE session.id = 2001
    ) as priceTicketSession
```
### Малое кол-во данных
```sql  
    QUERY PLAN
    Aggregate (cost=5972.25..5972.26 rows=1 width=16)
    -> Nested Loop Left Join (cost=1000.98..5972.22 rows=1 width=30)
    -> Nested Loop Left Join (cost=1000.83..5963.94 rows=1 width=30)
    -> Nested Loop Left Join (cost=1000.56..5963.00 rows=1 width=30)
    -> Nested Loop Left Join (cost=1000.28..5954.70 rows=1 width=32)
    Join Filter: (session.id = tickets.session_id)
    -> Index Scan using session_pkey on session (cost=0.28..8.30 rows=1 width=32)
    Index Cond: (id = 2001)
    -> Gather (cost=1000.00..5945.40 rows=80 width=24)
    Workers Planned: 1
    -> Parallel Seq Scan on tickets (cost=0.00..4937.40 rows=47 width=24)
    Filter: (session_id = 2001)
    -> Index Scan using movies_pkey on movies (cost=0.28..8.29 rows=1 width=14)
    Index Cond: (id = session.movie_id)
    -> Index Scan using places_pkey on places (cost=0.27..0.94 rows=1 width=16)
    Index Cond: (id = tickets.place_id)
    -> Index Scan using halls_pkey on halls (cost=0.14..8.16 rows=1 width=16)
    Index Cond: (id = session.hall_id)
```
### Большое кол-во данных
```sql  
    QUERY PLAN
    Aggregate (cost=12610.09..12610.10 rows=1 width=16)
    -> Nested Loop Left Join (cost=1001.27..12610.06 rows=1 width=30)
    -> Nested Loop Left Join (cost=1001.13..12601.78 rows=1 width=30)
    -> Nested Loop Left Join (cost=1000.86..12600.85 rows=1 width=30)
    -> Nested Loop Left Join (cost=1000.43..12592.41 rows=1 width=32)
    Join Filter: (session.id = tickets.session_id)
    -> Index Scan using session_pkey on session (cost=0.43..8.45 rows=1 width=32)
    Index Cond: (id = 20074907)
    -> Gather (cost=1000.00..12583.33 rows=50 width=24)
    Workers Planned: 2
    -> Parallel Seq Scan on tickets (cost=0.00..11578.33 rows=21 width=24)
    Filter: (session_id = 20074907)
    -> Index Scan using movies_pkey on movies (cost=0.42..8.44 rows=1 width=14)
    Index Cond: (id = session.movie_id)
    -> Index Scan using places_pkey on places (cost=0.27..0.93 rows=1 width=16)
    Index Cond: (id = tickets.place_id)
    -> Index Scan using halls_pkey on halls (cost=0.14..8.16 rows=1 width=16)
    Index Cond: (id = session.hall_id)
```

### После добавления индексов на предыдущих шагах
```sql  
    QUERY PLAN
    Aggregate (cost=121.81..121.82 rows=1 width=16)
    -> Nested Loop Left Join (cost=1.70..121.78 rows=1 width=30)
    -> Nested Loop Left Join (cost=1.55..113.50 rows=1 width=30)
    -> Nested Loop Left Join (cost=1.28..112.57 rows=1 width=30)
    -> Nested Loop Left Join (cost=0.86..104.12 rows=1 width=32)
    Join Filter: (session.id = tickets.session_id)
    -> Index Scan using session_pkey on session (cost=0.43..8.45 rows=1 width=32)
    Index Cond: (id = 20074907)
    -> Index Scan using tickets_session_id_place_id on tickets (cost=0.42..95.05 rows=50 width=24)
    Index Cond: (session_id = 20074907)
    -> Index Scan using movies_pkey on movies (cost=0.42..8.44 rows=1 width=14)
    Index Cond: (id = session.movie_id)
    -> Index Scan using places_pkey on places (cost=0.27..0.93 rows=1 width=16)
    Index Cond: (id = tickets.place_id)
    -> Index Scan using halls_pkey on halls (cost=0.14..8.16 rows=1 width=16)
    Index Cond: (id = session.hall_id)
```