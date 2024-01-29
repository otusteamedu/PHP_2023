-- movies --
INSERT INTO movies (name, duration, release_date)
SELECT
    rand_movie_name() || ' ' || rand_str((1 + random()*30)::integer),
    rand_duration(),
    rand_release_date_new()
FROM
    generate_series(1, 100000) AS gs(id);

-- halls --
INSERT INTO halls(name)
SELECT
    rand_str(10)
FROM
    generate_series(1, 10) as gs(id);

-- seats --
INSERT INTO seats(seat_number, row_number)
SELECT
    rand_str(2),
    rand_between(1, 10)
FROM
    generate_series(1, 1000) as gs(id);

-- seat_map --
INSERT INTO seat_map(hall_id, seat_id)
SELECT
    rand_between(1, 10),
    rand_between(1, 1000)
FROM
    generate_series(1, 1000) as gs(id);

-- sessions --
INSERT INTO sessions(datetime, hall_id, movie_id)
SELECT
    rand_date_time('2023-12-01', '2024-01-31'),
    rand_between(1, 10),
    rand_between(1, 100000)
FROM
    generate_series(1, 100000) as gs(id);

-- session_price --
INSERT INTO session_price(
    seat_map_id, session_id, price
)
SELECT
    rand_between(1, 1000),
    rand_between(1, 100000),
    rand_between(500, 1000)
FROM
    generate_series(1, 100000) as gs(id);

-- tickets --
INSERT INTO tickets (session_id, status, date_purchase, seat_map_id)
SELECT
    rand_between(20004, 50004),
    rand_ticket_status(),
    rand_date_time('2023-12-01', '2024-01-01'),
    rand_between(1, 900)
FROM generate_series(1, 100000) as gs(id);
