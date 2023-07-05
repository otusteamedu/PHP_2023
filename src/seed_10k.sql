-- Halls
INSERT INTO hall (name, capacity, description)
VALUES
    ('Зал 1', 500, 'Основной зал'),
    ('Зал 2', 180, 'Малый зал'),
    ('Зал 3', 120, 'VIP зал');

-- Hall 1
INSERT INTO hall_row (seats, hall_id)
SELECT
    30,
    (SELECT id FROM hall WHERE name = 'Зал 1')
FROM generate_series(1, 30) n;

-- Hall 2
INSERT INTO hall_row (seats, hall_id)
SELECT
    30,
    (SELECT id FROM hall WHERE name = 'Зал 2')
FROM generate_series(1, 30) n;

-- Hall 3
INSERT INTO hall_row (seats, hall_id)
SELECT
    30,
    (SELECT id FROM hall WHERE name = 'Зал 3')
FROM generate_series(1, 30) n;

INSERT INTO movie (name, director, genre, duration)
SELECT
    'Movie ' || n,
    'Any director',
    'Any genre',
    120
FROM generate_series(1, 3) n;

INSERT INTO showtime (hall_id, movie_id, start_time, duration, price)
SELECT
    random_int(3),
    random_int(3),
    random_date('2018-07-04'::TIMESTAMP, '2023-07-04'::TIMESTAMP),
    random_int(320),
    random_decimal(100.00, 800.00)
FROM generate_series(1, 185) n;

INSERT INTO customer (first_name, last_name, email, phone)
SELECT
    'Customer ' || n,
    'Lastname ' || n,
    'dummy@mail.com',
    '+7123456789'
FROM generate_series(1, 4000) n;

INSERT INTO ticket (showtime_id, customer_id, row, seat, price, sale_date)
SELECT
    random_int(100),
    random_int(3000),
    random_int(20),
    random_int(10),
    random_decimal(100.00, 500.00),
    random_date('2018-07-04'::TIMESTAMP, '2023-07-04'::TIMESTAMP)
FROM
    generate_series(1, 5900) AS n;
