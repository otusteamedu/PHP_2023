DO $$
DECLARE
    count INT := 10000;
BEGIN

INSERT INTO films (name, release_date)
SELECT random_string(10), random_date('2000-01-01', '2025-12-31')
FROM generate_series(1, count);

INSERT INTO halls (number)
VALUES (1), (2), (3), (4);

INSERT INTO places (row_number, place, hall_id)
SELECT row_number, place_number, hall.id
FROM (SELECT generate_series(1, 10) AS row_number) AS rows
    CROSS JOIN (SELECT generate_series(1, 15) AS place_number) AS places
    CROSS JOIN halls as hall;

INSERT INTO clients (name, surname, phone)
SELECT random_string(5), random_string(7), generate_random_phone_number()
FROM generate_series(1, count);

INSERT INTO prices (price)
SELECT generate_random_number(200, 1000)
FROM generate_series(1, 20);

INSERT INTO sessions (date_start, time_start, hall_id, film_id)
SELECT random_date('2020-01-01', '2025-12-31'), random_time('08:00:00', '23:59:59'), generate_random_number(1, 4), generate_random_number(1, 100)
FROM generate_series(1, count);

INSERT INTO session_place_price (place_id, price_id, session_id)
SELECT
    places.id,
    generate_random_number(1, 20),
    sessions.id
FROM places
CROSS JOIN sessions;
INSERT INTO tickets (final_price, client_id, film_id, session_place_price_id, sold_date, sold_time)
SELECT
    generate_random_number(100, 1000),
    generate_random_number(1, count),
    generate_random_number(1, count),
    generate_random_number(1, 60000),
    random_date('2020-01-01', (SELECT CURRENT_DATE)),
    random_time('00:00:00', '23:59:59')
FROM generate_series(1, generate_random_number(100, count));
END $$;