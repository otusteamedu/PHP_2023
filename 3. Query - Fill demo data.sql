-- Сеансы
CREATE TABLE show (
    id SERIAL PRIMARY KEY,
    room_id INT NOT NULL,
    movie_id INT NOT NULL,
    price_id INT NOT NULL,
    schedule TIMESTAMP WITH TIME ZONE,
    FOREIGN KEY (room_id) REFERENCES room(id),
    FOREIGN KEY (movie_id) REFERENCES movie(id),
    FOREIGN KEY (price_id) REFERENCES price(id)  
);

-- кинотеатр
INSERT INTO cinema (name) VALUES ('Ромашка IMAX');

-- Залы
INSERT INTO room (cinema_id, name) 
VALUES 
    (1, 'Синий'), 
    (1, 'Желтый'), 
    (1, 'Красный VIP');

-- Типы мест
INSERT INTO seattype (name) 
VALUES 
    ('Эконом'), 
    ('Стандарт'),
    ('Комфорт'), 
    ('Повышенный комфорт'),
    ('VIP');


---------------
-- СИНИЙ ЗАЛ --
---------------

-- Места в синем зале (1 ряд)
INSERT INTO seat (room_id, seattype_id, line, number) 
SELECT 1, 1, 1, generate_series(1, 19);
-- Места в синем зале (2 ряд)
INSERT INTO seat (room_id, seattype_id, line, number) 
SELECT 1, 1, 2, generate_series(1, 21);
-- Места в синем зале (3 ряд)
INSERT INTO seat (room_id, seattype_id, line, number) 
SELECT 1, 1, 3, generate_series(1, 23);

-- Места в синем зале (4 ряд)
INSERT INTO seat (room_id, seattype_id, line, number) 
SELECT 1,
       CASE 
           WHEN seatnumber > 5 AND seatnumber < 21 THEN 2
           ELSE 1
       END,
       4,
       seatnumber
FROM generate_series(1, 24) AS seatnumber;

-- Места в синем зале (5 ряд)
INSERT INTO seat (room_id, seattype_id, line, number) 
SELECT 1,
       CASE 
           WHEN seatnumber > 5 AND seatnumber < 23 THEN 2
           ELSE 1
       END,
       5,
       seatnumber
FROM generate_series(1, 26) AS seatnumber;

-- Места в синем зале (6 ряд)
INSERT INTO seat (room_id, seattype_id, line, number) 
SELECT 1,
       CASE 
           WHEN seatnumber > 5 AND seatnumber < 25 THEN 2
           ELSE 1
       END,
       6,
       seatnumber
FROM generate_series(1, 28) AS seatnumber;

-- Места в синем зале (7 ряд)
INSERT INTO seat (room_id, seattype_id, line, number) 
SELECT 1,
       CASE 
           WHEN seatnumber > 5 AND seatnumber < 26 THEN 3
           ELSE 1
       END,
       7,
       seatnumber
FROM generate_series(1, 29) AS seatnumber;

-- Места в синем зале (8 ряд)
INSERT INTO seat (room_id, seattype_id, line, number) 
SELECT 1,
       CASE 
           WHEN seatnumber > 5 AND seatnumber < 28 THEN 3
           ELSE 1
       END,
       8,
       seatnumber
FROM generate_series(1, 31) AS seatnumber;

-- Места в синем зале (9 ряд)
INSERT INTO seat (room_id, seattype_id, line, number) 
SELECT 1,
       CASE 
           WHEN seatnumber > 5 AND seatnumber < 29 THEN 2
           ELSE 1
       END,
       9,
       seatnumber
FROM generate_series(1, 32) AS seatnumber;

-- Места в синем зале (10 ряд)
INSERT INTO seat (room_id, seattype_id, line, number) 
SELECT 1,
       CASE 
           WHEN seatnumber > 5 AND seatnumber < 31 THEN 2
           ELSE 1
       END,
       10,
       seatnumber
FROM generate_series(1, 34) AS seatnumber;

-- Места в синем зале (11 ряд)
INSERT INTO seat (room_id, seattype_id, line, number) 
SELECT 1,
       CASE 
           WHEN seatnumber > 5 AND seatnumber < 33 THEN 2
           ELSE 1
       END,
       11,
       seatnumber
FROM generate_series(1, 37) AS seatnumber;


----------------
-- ЖЕЛТЫЙ ЗАЛ --
----------------

-- Места в желтом зале
INSERT INTO seat (room_id, seattype_id, line, number) 
SELECT 2, 
    blue.seattype_id, 
    blue.line,
    blue.number
FROM seat AS blue
WHERE blue.room_id = 1;


-----------------
-- КРАСНЫЙ ЗАЛ --
-----------------

-- Места в красном зале (Ряд 1)
INSERT INTO seat (room_id, seattype_id, line, number) 
SELECT 3, 4, 1, generate_series(1, 6);
-- Места в красном зале (Ряд 2)
INSERT INTO seat (room_id, seattype_id, line, number) 
SELECT 3, 4, 2, generate_series(1, 8);
-- Места в красном зале (Ряд 3)
INSERT INTO seat (room_id, seattype_id, line, number) 
SELECT 3, 5, 3, generate_series(1, 10);
-- Места в красном зале (Ряд 4)
INSERT INTO seat (room_id, seattype_id, line, number) 
SELECT 3, 5, 35, generate_series(1, 12);


-- Карточки цен
INSERT INTO price (name) 
VALUES ('Цены 1'), ('Цены 2'), ('Цены 3'), ('Цены 4'), ('Цены VIP 1'), ('Цены VIP 2'), ('Цены VIP 3');

-- Цены карточки 1
INSERT INTO priceitem (price_id, seattype_id, price)
VALUES 
    (1, 1, 250.00), 
    (1, 2, 450.00), 
    (1, 3, 600.00);

-- Цены карточки 2
INSERT INTO priceitem (price_id, seattype_id, price)
VALUES 
    (2, 1, 350.00), 
    (2, 2, 500.00), 
    (2, 3, 650.00);

-- Цены карточки 3
INSERT INTO priceitem (price_id, seattype_id, price)
VALUES 
    (3, 1, 400.00), 
    (3, 2, 600.00), 
    (3, 3, 800.00);

-- Цены карточки 4
INSERT INTO priceitem (price_id, seattype_id, price)
VALUES 
    (4, 1, 500.00), 
    (4, 2, 900.00), 
    (4, 3, 1300.00);

-- Цены карточки 5
INSERT INTO priceitem (price_id, seattype_id, price)
VALUES 
    (5, 4, 1000.00), 
    (5, 5, 1500.00); 

-- Цены карточки 6
INSERT INTO priceitem (price_id, seattype_id, price)
VALUES 
    (6, 4, 1700.00), 
    (6, 5, 2000.00);

-- Цены карточки 7
INSERT INTO priceitem (price_id, seattype_id, price)
VALUES 
    (7, 4, 2000.00), 
    (7, 5, 2500.00);  


-- Фильмы
INSERT INTO movie (name, release, length)
VALUES 
('Мстители', '2012-05-04', 143),
('Темный рыцарь: Возрождение легенды', '2012-07-20', 165),
('Хоббит: Нежданное путешествие', '2012-12-14', 169),
('Невероятный Человек-паук', '2012-07-03', 136),
('Властелин колец', '2012-03-23', 178);


-- Сеансы на неделю в синем зале
WITH days AS (
    SELECT generate_series(
        current_date,
        current_date + interval '1 week',
        '1 day'
    ) as day
),
hours AS (
    SELECT EXTRACT(HOUR FROM generate_series(
        '1970-01-01 10:00'::timestamp,
        '1970-01-01 23:50'::timestamp,
        '3 hours'::interval
    )) as hour
),
all_times AS (
    SELECT
        (day + (hour || ' hours')::interval) AS showtime
    FROM
        days,
        hours
)
INSERT INTO show (room_id, movie_id, price_id, schedule)
SELECT
    1,
    floor(random() * 5 + 1),
    CASE
        WHEN extract(ISODOW from showtime) in (6,7) THEN 
            CASE
                WHEN extract(hour from showtime) < 14 THEN 2
                WHEN extract(hour from showtime) BETWEEN 14 AND 18 THEN 3
                ELSE 4
            END
        ELSE
            CASE
                WHEN extract(hour from showtime) < 14 THEN 1
                WHEN extract(hour from showtime) BETWEEN 14 AND 18 THEN 2
                ELSE 3
            END
    END,
    showtime
FROM
    all_times;

-- Сеансы на неделю в желтом зале
WITH days AS (
    SELECT generate_series(
        current_date,
        current_date + interval '1 week',
        '1 day'
    ) as day
),
hours AS (
    SELECT EXTRACT(HOUR FROM generate_series(
        '1970-01-01 10:00'::timestamp,
        '1970-01-01 23:50'::timestamp,
        '3 hours'::interval
    )) as hour
),
all_times AS (
    SELECT
        (day + (hour || ' hours')::interval) AS showtime
    FROM
        days,
        hours
)
INSERT INTO show (room_id, movie_id, price_id, schedule)
SELECT
    2,
    floor(random() * 5 + 1),
    CASE
        WHEN extract(ISODOW from showtime) in (6,7) THEN 
            CASE
                WHEN extract(hour from showtime) < 14 THEN 2
                WHEN extract(hour from showtime) BETWEEN 14 AND 18 THEN 3
                ELSE 4
            END
        ELSE
            CASE
                WHEN extract(hour from showtime) < 14 THEN 1
                WHEN extract(hour from showtime) BETWEEN 14 AND 18 THEN 2
                ELSE 3
            END
    END,
    showtime
FROM
    all_times;

-- Сеансы на неделю в красном зале (VIP)
WITH days AS (
    SELECT generate_series(
        current_date,
        current_date + interval '1 week',
        '1 day'
    ) as day
),
hours AS (
    SELECT EXTRACT(HOUR FROM generate_series(
        '1970-01-01 14:00'::timestamp,
        '1970-01-01 23:50'::timestamp,
        '3 hours'::interval
    )) as hour
),
all_times AS (
    SELECT
        (day + (hour || ' hours')::interval) AS showtime
    FROM
        days,
        hours
)
INSERT INTO show (room_id, movie_id, price_id, schedule)
SELECT
    3,
    floor(random() * 5 + 1),
    CASE
        WHEN extract(ISODOW from showtime) in (6,7) THEN 
            CASE
                WHEN extract(hour from showtime) < 18 THEN 6
                ELSE 7
            END
        ELSE
            CASE
                WHEN extract(hour from showtime) < 18 THEN 5
                ELSE 6
            END
    END,
    showtime
FROM
    all_times;

-- формируем список онлайн-покупаелей
INSERT INTO client (name) VALUES 
('Смирнов Иван'),
('Орлов Петр'),
('Волков Федор'),
('Лебедев Егор'),
('Романов Виктор'),
('Зайцев Антон'),
('Кузнецов Григорий'),
('Морозов Дмитрий'),
('Попов Михаил'),
('Васильев Николай'),
('Новиков Алексей'),
('Белов Семён'),
('Горшков Павел'),
('Трофимов Вячеслав'),
('Макаров Владислав'),
('Виноградов Захар'),
('Соколов Илья'),
('Михайлов Вадим'),
('Федоров Максим'),
('Тихонов Роман'),
('Данилов Тимофей'),
('Чернов Евгений'),
('Борисов Сергей'),
('Иванов Кирилл'),
('Алексеев Денис'),
('Яковлев Степан'),
('Сергеев Юрий'),
('Русаков Борис'),
('Никитин Леонид'),
('Ширяев Станислав'),
('Жуковский Аркадий');

-- Заполняем таблицу 10000 проданных билетов
WITH 
randomized_show as (
SELECT
    sh.id AS show_id,
    st.id AS seat_id,
    pi.price,
    CASE 
        WHEN random() < 0.02 
        THEN floor(random() * 30 + 1) 
        ELSE NULL 
    END AS client_id
FROM show AS sh
JOIN seat AS st
    ON st.room_id = sh.room_id
LEFT JOIN priceitem AS pi
    ON pi.price_id = sh.price_id
    AND pi.seattype_id = st.seattype_id
)
INSERT INTO ticket(show_id, seat_id, client_id, price)
SELECT rs.show_id, rs.seat_id, rs.client_id, rs.price
FROM randomized_show AS rs
ORDER BY RANDOM()
LIMIT 10000;
