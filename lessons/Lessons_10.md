# 10. Индексирование данных

## Создание таблиц
```sql
CREATE TABLE cinemas (
                         id INT PRIMARY KEY NOT NULL,
                         name VARCHAR(255) NOT NULL,
                         address VARCHAR(255) NOT NULL
);

CREATE TABLE halls (
                       id INT PRIMARY KEY NOT NULL,
                       cinemas_id INT NOT NULL,
                       name VARCHAR(255) NOT NULL,
                       FOREIGN KEY (cinemas_id) REFERENCES cinemas(id)
);

CREATE TABLE movies (
                        id INT PRIMARY KEY NOT NULL,
                        title VARCHAR(255) NOT NULL,
                        duration INT NOT NULL,
                        release_date TIMESTAMP NOT NULL
);

CREATE TABLE seats (
                       id INT PRIMARY KEY NOT NULL,
                       hall_id INT NOT NULL,
                       row_number INT NOT NULL,
                       seat_number INT NOT NULL,
                       FOREIGN KEY (hall_id) REFERENCES halls(id)
);

CREATE TABLE prices (
                        id INT PRIMARY KEY NOT NULL,
                        amount NUMERIC(10,2) NOT NULL
);

CREATE TABLE sessions (
                          id INT PRIMARY KEY NOT NULL,
                          cinemas_id INT NOT NULL,
                          halls_id INT NOT NULL,
                          movies_id INT NOT NULL,
                          seats_id INT NOT NULL,
                          prices_id INT NOT NULL,
                          start_time TIMESTAMP NOT NULL,
                          end_time TIMESTAMP NOT NULL,
                          status INT NOT NULL,
                          FOREIGN KEY (cinemas_id) REFERENCES cinemas(id),
                          FOREIGN KEY (halls_id) REFERENCES halls(id),
                          FOREIGN KEY (movies_id) REFERENCES movies(id),
                          FOREIGN KEY (seats_id) REFERENCES seats(id),
                          FOREIGN KEY (prices_id) REFERENCES prices(id)
);

CREATE TABLE tickets (
                         id INT PRIMARY KEY NOT NULL,
                         session_id INT NOT NULL,
                         seat_id INT NOT NULL,
                         FOREIGN KEY (session_id) REFERENCES sessions(id),
                         FOREIGN KEY (seat_id) REFERENCES seats(id)
);

```


# Создание тестовых даных 100к
```sql
DO $$
    DECLARE
        max_records INT := 100000; 
        i INT;
    BEGIN
        SET LOCAL synchronous_commit TO OFF;

        -- Заполнение таблицы cinemas
        FOR i IN 1..max_records LOOP
                INSERT INTO cinemas (id, name, address)
                VALUES (i, 'Кинотеатр ' || i, 'Улица ' || i);
            END LOOP;

        -- Заполнение таблицы halls
        FOR i IN 1..max_records LOOP
                INSERT INTO halls (id, cinemas_id, name)
                VALUES (i, ((i - 1) / 10) + 1, 'Зал ' || i); -- у каждого кинотеатра есть 10 залов
            END LOOP;

        -- Заполнение таблицы movies
        FOR i IN 1..max_records LOOP
                INSERT INTO movies (id, title, duration, release_date)
                VALUES (i, 'Фильм ' || i, (i % 180) + 60, CURRENT_DATE + (i % 30));
            END LOOP;

        -- Заполнение таблицы seats
        FOR i IN 1..max_records LOOP
                INSERT INTO seats (id, hall_id, row_number, seat_number)
                VALUES (i, ((i - 1) / 100) + 1, ((i - 1) / 10) + 1, (i % 10) + 1); -- в каждом зале 100 мест
            END LOOP;

        -- Заполнение таблицы prices
        FOR i IN 1..max_records LOOP
                INSERT INTO prices (id, amount)
                VALUES (i, (RANDOM() * (300 - 100) + 100)::DECIMAL(10,2)); -- Случайная цена от 100 до 300
            END LOOP;

        -- Заполнение таблицы sessions
        FOR i IN 1..max_records LOOP
                INSERT INTO sessions (id, cinemas_id, halls_id, movies_id, seats_id, prices_id, start_time, end_time, status)
                VALUES (i, ((i - 1) / 10) + 1, ((i - 1) / 100) + 1, i, i, i, CURRENT_TIMESTAMP + (i * INTERVAL '1 minute'), CURRENT_TIMESTAMP + (i * INTERVAL '1 minute') + (i % 180 + 60) * INTERVAL '1 minute', i % 3 + 1);
            END LOOP;

        -- Заполнение таблицы tickets
        FOR i IN 1..max_records LOOP
                INSERT INTO tickets (id, session_id, seat_id)
                VALUES (i, i, i);
            END LOOP;

        SET LOCAL synchronous_commit TO ON;
    END $$;

```


# Запросы


### Выбор всех фильмов на сегодня:
ускорил индексом btree
```sql
expline SELECT m.title 
FROM movies m
JOIN sessions s ON m.id = s.movies_id
WHERE s.start_time >= CURRENT_DATE
AND s.start_time < CURRENT_DATE + INTERVAL '1 day';

-- Hash Join  (cost=3203.12..5416.62 rows=1450 width=16)
--Hash Cond: (m.id = s.movies_id)
--  ->  Seq Scan on movies m  (cost=0.00..1824.00 rows=100000 width=20)
--  ->  Hash  (cost=3185.00..3185.00 rows=1450 width=4)
--        ->  Seq Scan on sessions s  (cost=0.00..3185.00 rows=1450 width=4)
--              Filter: ((start_time >= CURRENT_DATE) AND (start_time < (CURRENT_DATE + '1 day'::interval)))

create index idx_start_time ON sessions (start_time);


-- Hash Join  (cost=84.42..2297.93 rows=1450 width=16)
--    Hash Cond: (m.id = s.movies_id)
--  ->  Seq Scan on movies m  (cost=0.00..1824.00 rows=100000 width=20)
--  ->  Hash  (cost=66.30..66.30 rows=1450 width=4)
--        ->  Index Scan using idx_start_time on sessions s  (cost=0.30..66.30 rows=1450 width=4) СТОИМОСТЬ СТАЛА МЕНЬШЕ
--              Index Cond: ((start_time >= CURRENT_DATE) AND (start_time < (CURRENT_DATE + '1 day'::interval)))

```

### Подсчёт проданных билетов за неделю:

start_time уже индекс создал
```sql
explain analyse
SELECT COUNT(*) FROM tickets t
                         JOIN sessions s ON t.session_id = s.id
WHERE s.start_time >= CURRENT_DATE - INTERVAL '7 days'
  AND s.start_time < CURRENT_DATE;

-- Aggregate  (cost=1811.85..1811.86 rows=1 width=8) (actual time=0.010..0.011 rows=1 loops=1)
--  ->  Hash Join  (cost=8.33..1811.84 rows=1 width=0) (actual time=0.009..0.010 rows=0 loops=1)
--        Hash Cond: (t.session_id = s.id)
--        ->  Seq Scan on tickets t  (cost=0.00..1541.00 rows=100000 width=4) (actual time=0.003..0.003 rows=1 loops=1)
--        ->  Hash  (cost=8.32..8.32 rows=1 width=4) (actual time=0.004..0.004 rows=0 loops=1)
--              Buckets: 1024  Batches: 1  Memory Usage: 8kB
--              ->  Index Scan using idx_start_session on sessions s  (cost=0.30..8.32 rows=1 width=4) (actual time=0.003..0.003 rows=0 loops=1)
--                    Index Cond: ((start_time >= (CURRENT_DATE - '7 days'::interval)) AND (start_time < CURRENT_DATE))
--Planning Time: 0.234 ms
--Execution Time: 0.026 ms


```

### Формирование афиши (фильмы, которые показывают сегодня):

start_time уже индекс создал
```sql
explain analyse
SELECT DISTINCT m.title 
FROM movies m
JOIN sessions s ON m.id = s.movies_id
WHERE s.start_time >= CURRENT_DATE
AND s.start_time < CURRENT_DATE + INTERVAL '1 day';

-- HashAggregate  (cost=2266.55..2276.16 rows=961 width=16) (actual time=12.950..13.030 rows=947 loops=1)
--  Group Key: m.title
--  Batches: 1  Memory Usage: 129kB
--  ->  Hash Join  (cost=55.53..2264.14 rows=961 width=16) (actual time=0.342..12.730 rows=947 loops=1)
--        Hash Cond: (m.id = s.movies_id)
--        ->  Seq Scan on movies m  (cost=0.00..1824.00 rows=100000 width=20) (actual time=0.004..5.045 rows=100000 loops=1)
--        ->  Hash  (cost=43.52..43.52 rows=961 width=4) (actual time=0.333..0.334 rows=947 loops=1)
--              Buckets: 1024  Batches: 1  Memory Usage: 42kB
--              ->  Index Scan using idx_start_session on sessions s  (cost=0.30..43.52 rows=961 width=4) (actual time=0.019..0.224 rows=947 loops=1)
--                    Index Cond: ((start_time >= CURRENT_DATE) AND (start_time < (CURRENT_DATE + '1 day'::interval)))
--Planning Time: 0.213 ms
--Execution Time: 13.100 ms

```

### Поиск 3 самых прибыльных фильмов за неделю:

start_time уже индекс создал
```sql
SELECT m.title, SUM(p.amount) AS total_amount
FROM movies m
JOIN sessions s ON m.id = s.movies_id
JOIN tickets t ON t.session_id = s.id
JOIN prices p ON s.prices_id = p.id
WHERE s.start_time >= CURRENT_DATE - INTERVAL '7 days'
AND s.start_time < CURRENT_DATE
GROUP BY m.title
ORDER BY total_amount DESC
LIMIT 3;

-- Limit  (cost=1828.51..1828.51 rows=1 width=48) (actual time=0.045..0.048 rows=0 loops=1)
--  ->  Sort  (cost=1828.51..1828.51 rows=1 width=48) (actual time=0.043..0.046 rows=0 loops=1)
--        Sort Key: (sum(p.amount)) DESC
--        Sort Method: quicksort  Memory: 25kB
--        ->  GroupAggregate  (cost=1828.47..1828.50 rows=1 width=48) (actual time=0.029..0.032 rows=0 loops=1)
--              Group Key: m.title
--              ->  Sort  (cost=1828.47..1828.48 rows=1 width=22) (actual time=0.028..0.030 rows=0 loops=1)
--                    Sort Key: m.title
--                    Sort Method: quicksort  Memory: 25kB
--                    ->  Nested Loop  (cost=8.92..1828.46 rows=1 width=22) (actual time=0.019..0.021 rows=0 loops=1)
--                          ->  Nested Loop  (cost=8.63..1820.15 rows=1 width=20) (actual time=0.019..0.021 rows=0 loops=1)
--                                ->  Hash Join  (cost=8.33..1811.84 rows=1 width=8) (actual time=0.018..0.020 rows=0 loops=1)
--                                      Hash Cond: (t.session_id = s.id)
--                                      ->  Seq Scan on tickets t  (cost=0.00..1541.00 rows=100000 width=4) (actual time=0.006..0.007 rows=1 loops=1)
--                                      ->  Hash  (cost=8.32..8.32 rows=1 width=12) (actual time=0.008..0.008 rows=0 loops=1)
--                                            Buckets: 1024  Batches: 1  Memory Usage: 8kB
--                                            ->  Index Scan using idx_start_session on sessions s  (cost=0.30..8.32 rows=1 width=12) (actual time=0.007..0.007 rows=0 loops=1)
--                                                  Index Cond: ((start_time >= (CURRENT_DATE - '7 days'::interval)) AND (start_time < CURRENT_DATE))
--                                ->  Index Scan using movies_pkey on movies m  (cost=0.29..8.31 rows=1 width=20) (never executed)
--                                      Index Cond: (id = s.movies_id)
--                          ->  Index Scan using prices_pkey on prices p  (cost=0.29..8.31 rows=1 width=10) (never executed)
--                                Index Cond: (id = s.prices_id)
--Planning Time: 0.498 ms
--Execution Time: 0.097 ms


```

### Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс:
Ускорил составным индексом btree
```sql
expline SELECT 
    se.hall_id, 
    se.row_number, 
    se.seat_number, 
    CASE WHEN t.id IS NULL THEN 'Free' ELSE 'Occupied' END AS seat_status
FROM seats se
LEFT JOIN tickets t ON se.id = t.seat_id AND t.session_id = 3
ORDER BY se.row_number, se.seat_number;

-- Sort  (cost=15088.34..15338.34 rows=100000 width=44)
--"  Sort Key: se.row_number, se.seat_number"
--  ->  Hash Left Join  (cost=1791.01..3707.02 rows=100000 width=44)
--        Hash Cond: (se.id = t.seat_id)
--        ->  Seq Scan on seats se  (cost=0.00..1541.00 rows=100000 width=16)
--        ->  Hash  (cost=1791.00..1791.00 rows=1 width=8)
--              ->  Seq Scan on tickets t  (cost=0.00..1791.00 rows=1 width=8)
--                    Filter: (session_id = 3)

CREATE INDEX idx_seats_on_row_number_and_seat_number ON seats(row_number, seat_number);
CREATE INDEX idx_tickets_on_session_id_and_seat_id ON tickets(session_id, seat_id);

    
-- Nested Loop Left Join  (cost=0.58..5365.36 rows=100000 width=44)
--  Join Filter: (se.id = t.seat_id)
--  ->  Index Scan using idx_seats_on_row_number_and_seat_number on seats se  (cost=0.29..3857.04 rows=100000 width=16)
--  ->  Materialize  (cost=0.29..8.32 rows=1 width=8)
--        ->  Index Scan using idx_tickets_on_session_id_and_seat_id on tickets t  (cost=0.29..8.31 rows=1 width=8) СТОИМОСТЬ СТАЛА МЕНЬШЕ
--              Index Cond: (session_id = 3)





```

### Вывести диапазон минимальной и максимальной цены за билет на конкретный сеанс:
тут нечего ускарять 
```sql
SELECT MIN(p.amount) AS min_price, MAX(p.amount) AS max_price
FROM prices p
JOIN sessions s ON p.id = s.prices_id
WHERE s.id = 2;
```