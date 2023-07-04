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
FROM generate_series(1, 300) n;

INSERT INTO showtime (hall_id, movie_id, start_time, duration, price)
SELECT
    random_int(3),
    random_int(20),
    random_date('2018-07-04'::TIMESTAMP, '2023-07-04'::TIMESTAMP),
    random_int(320),
    random_decimal(100.00, 800.00)
FROM generate_series(1, 1850) n;

INSERT INTO customer (first_name, last_name, email, phone)
SELECT
    'Customer ' || n,
    'Lastname ' || n,
    'dummy@mail.com',
    '+7123456789'
FROM generate_series(1, 4000000) n;

-- Too long and wrong
INSERT INTO ticket (showtime_id, customer_id, row, seat, price, sale_date)
SELECT
    s.id,
    random_int(9000),
    (SELECT hr.id row FROM hall_row hr
        INNER JOIN hall h on h.id = hr.hall_id
        ORDER BY random()
        LIMIT 1),
    (SELECT random_int(hr.seats) seat
        FROM hall_row hr
        INNER JOIN hall h on h.id = hr.hall_id
        INNER JOIN showtime s on h.id = s.hall_id
        LEFT JOIN ticket t on s.id = t.showtime_id
        ORDER BY random()
        LIMIT 1),
    s.price AS price,
    random_date('2023-01-01'::TIMESTAMP, '2023-08-01'::TIMESTAMP)
FROM
    generate_series(1, 9000) AS n
        CROSS JOIN showtime s
;

-- Wrong but fast
INSERT INTO ticket (showtime_id, customer_id, row, seat, price, sale_date)
SELECT
    random_int(100),
    random_int(3000),
    random_int(20),
    random_int(10),
    random_decimal(100.00, 500.00),
    random_date('2018-07-04'::TIMESTAMP, '2023-07-04'::TIMESTAMP)
FROM
    generate_series(1, 5990000) AS n;
