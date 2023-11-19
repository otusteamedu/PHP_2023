INSERT INTO movies (id, name, age, description, poster, trailer, duration)
SELECT
    gs,
    'Movie ' || gs,
    random_in_range(12, 18),
    'Description ' || gs,
    null,
    null,
    '02:00:00'
FROM
    generate_series(1, 10000) as gs;


INSERT INTO sessions (id, date, movie_id, hall_id)
SELECT
    gs,
    random_date('2023-09-01', '2023-12-31'),
    gs,
    1
FROM generate_series(1, 10000) as gs;


INSERT INTO seats (id, row, place, hall_id)
SELECT
    gs,
    random_in_range(1, 100),
    random_in_range(1, 100),
    1
FROM generate_series(1, 100) as gs;

INSERT INTO tickets (id, seat_id, session_id, price, status, purchased_at)
SELECT
    gs,
    random_in_range(1, 100),
    random_in_range(1, 10000),
    random_in_range(100, 1000),
    random_in_range(0, 1),
    random_date('2023-09-01', '2023-12-31')
FROM generate_series(1, 10000) as gs;
