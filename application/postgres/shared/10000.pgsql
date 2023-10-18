TRUNCATE TABLE films RESTART IDENTITY CASCADE;
TRUNCATE TABLE film_type_to_films RESTART IDENTITY CASCADE;
TRUNCATE TABLE film_genres RESTART IDENTITY CASCADE;
TRUNCATE TABLE screenings RESTART IDENTITY CASCADE;
TRUNCATE TABLE visitors RESTART IDENTITY CASCADE;
TRUNCATE TABLE tickets RESTART IDENTITY CASCADE;

INSERT INTO films (age_restriction_id, name, duration, created_at, updated_at)
SELECT
    random_between(1, 4),
    random_string(random_between(20, 30)),
    random_between(100, 200),
    CURRENT_TIMESTAMP + (random_between(0, 200) || ' days')::INTERVAL,
                CURRENT_TIMESTAMP + (random_between(0, 200) || ' days')::INTERVAL
FROM generate_series(1, 10000);

INSERT INTO film_type_to_films (film_id, film_type_id, created_at, updated_at)
SELECT
    id,
    random_between(1, 4),
    CURRENT_TIMESTAMP + (random_between(0, 200) || ' days')::INTERVAL,
                CURRENT_TIMESTAMP + (random_between(0, 200) || ' days')::INTERVAL
FROM films;

INSERT INTO film_type_to_films (film_id, film_type_id, created_at, updated_at)
SELECT
    id,
    random_between(1, 4),
    CURRENT_TIMESTAMP + (random_between(0, 200) || ' days')::INTERVAL,
                CURRENT_TIMESTAMP + (random_between(0, 200) || ' days')::INTERVAL
FROM films
ORDER BY RANDOM()
    LIMIT random_between (100, 10000)
ON CONFLICT DO NOTHING;

INSERT INTO film_genres (film_id, genre_id, created_at, updated_at)
SELECT
    id,
    random_between(1, 5),
    CURRENT_TIMESTAMP + (random_between(0, 200) || ' days')::INTERVAL,
                CURRENT_TIMESTAMP + (random_between(0, 200) || ' days')::INTERVAL
FROM films;

INSERT INTO screenings (hall_id, film_id, film_type_id, base_price, start_at, created_at, updated_at)
SELECT
    random_between (1, 3),
    films.id,
    ft.id,
    random_between(100, 400),
    CURRENT_TIMESTAMP + (random_between(0, 200) || ' days')::INTERVAL,
                CURRENT_TIMESTAMP + (random_between(0, 200) || ' days')::INTERVAL,
                CURRENT_TIMESTAMP + (random_between(0, 200) || ' days')::INTERVAL
FROM films
         INNER JOIN film_type_to_films AS ftt
                    ON films.id = ftt.film_id
         INNER JOIN film_types AS ft
                    ON ft.id = ftt.film_type_id
ORDER BY RANDOM()
    LIMIT 10000;

INSERT INTO visitors (screening_id, cashless_payment, price, discount_percent, created_at, updated_at)
SELECT
    t.id,
    random_between(0, 1)::BOOLEAN,
        random_between(100, 400),
    random_between(0, 10),
    CURRENT_TIMESTAMP + (random_between(0, 200) || ' days')::INTERVAL,
                CURRENT_TIMESTAMP + (random_between(0, 200) || ' days')::INTERVAL
FROM (
         SELECT generate_series(1, 50), id
         FROM screenings
         ORDER BY RANDOM()
             LIMIT 10000
     ) AS t;

INSERT INTO tickets (visitor_id, seat, is_child, created_at, updated_at)
SELECT
    id,
    random_between(1, 150),
    random_between(0, 1)::BOOLEAN,
                CURRENT_TIMESTAMP + (random_between(0, 200) || ' days')::INTERVAL,
                CURRENT_TIMESTAMP + (random_between(0, 200) || ' days')::INTERVAL
FROM visitors;