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


# Запросы с explain
```sql
-- Выбор всех фильмов на сегодня
explain
select * FROM sessions
                  join movies m on m.id = sessions.movies_id
WHERE start_time >= CURRENT_DATE
  AND start_time < CURRENT_DATE + INTERVAL '1 day';

-- Hash Join  (cost=1083.56..4397.18 rows=528 width=576)
--  Hash Cond: (sessions.movies_id = m.id)
--  ->  Seq Scan on sessions  (cost=0.00..3312.24 rows=528 width=44)
--  ->  Hash  (cost=939.36..939.36 rows=11536 width=532)
--        Filter: ((start_time >= CURRENT_DATE) AND (start_time < (CURRENT_DATE + '1 day'::interval)))
--        ->  Seq Scan on movies m  (cost=0.00..939.36 rows=11536 width=532)


create index idx_start_session ON sessions (start_time);


-- Hash Join  (cost=41.57..2247.73 rows=716 width=76)
--  Hash Cond: (m.id = sessions.movies_id)
--  ->  Seq Scan on movies m  (cost=0.00..1824.00 rows=100000 width=32)
--  ->  Hash  (cost=32.62..32.62 rows=716 width=44)
--        ->  Index Scan using idx_start_session on sessions  (cost=0.30..32.62 rows=716 width=44)
--              Index Cond: ((start_time >= CURRENT_DATE) AND (start_time < (CURRENT_DATE + '1 day'::interval)))
```

# Просто запросы
```sql
-- Подсчёт проданных билетов за неделю
select count(*) from tickets;

-- Поиск 3 самых прибыльных фильмов за неделю
select m.title, sum(p.amount) as amount from sessions
                                                 join prices p on sessions.prices_id = p.id
                                                 join movies m on m.id = sessions.movies_id WHERE sessions.start_time < CURRENT_DATE + INTERVAL '7 day'
group by m.title ORDER BY amount DESC;

-- Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
select * from sessions where status = 2 and id = 1; -- status - 2 билет в продаже
```