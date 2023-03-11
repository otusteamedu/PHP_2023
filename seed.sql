-- Параметры
SET SESSION my.cinemas_count = '50';
SET SESSION my.halls_count = '150';
SET SESSION my.seats_count = '1500';
SET SESSION my.genres_count = '50';
SET SESSION my.movies_count = '1000';
SET SESSION my.sessions_count = '3000';
SET SESSION my.clients_count = '2000';
SET SESSION my.tickets_count = '5000';

SET SESSION my.start_date = '1941-01-01';

-- 1. Фильмы
INSERT INTO cinemas (title, description, address, thumbnail, halls_count)
SELECT
    concat('Cinema ', id),
    concat('Cinema ', id, ' description'),
    concat('Cinema ', id, ' address'),
    concat('/cinemas/', id, '/thumbnail.webp'),
    random_between(10, 50)
FROM GENERATE_SERIES(
    1, current_setting('my.cinemas_count')::int
) as id;

-- 2. Кинозалы
INSERT INTO halls (cinema_id, title, seats_count)
SELECT
    random_between(1, (current_setting('my.cinemas_count'))::int),
    concat('Hall ', id),
    random_between(100, 800)
FROM GENERATE_SERIES(
    1, current_setting('my.halls_count')::int
) as id;

-- 3. Места
INSERT INTO seats (hall_id, row, number)
SELECT
    random_between(1, (current_setting('my.halls_count'))::int),
    random_between(1, 35),
    id
FROM GENERATE_SERIES(
    1, current_setting('my.seats_count')::int
) as id;

-- 4. Жанры
INSERT INTO genres (title, description)
SELECT
    concat('Genre ', id),
    concat('Genre ', id, ' description')
FROM GENERATE_SERIES(
    1, current_setting('my.genres_count')::int
) as id;

-- 5. Фильмы
INSERT INTO movies (
    genre_id, title, description, duration,
    release_date, rental_start,
    rental_finish, rating, thumbnail
)
SELECT
    random_between(1, current_setting('my.genres_count')::int),
    concat('Movie ', id),
    concat('Movie ', id, ' description'),
    random_between(60, 200),
    random_timestamp(current_setting('my.start_date')::timestamp, NOW()),
    random_timestamp(current_setting('my.start_date')::timestamp, NOW()),
    random_timestamp(current_setting('my.start_date')::timestamp, NOW()),
    random() * 10,
    concat('/movies/', id, '/thumbnail.webp')
FROM GENERATE_SERIES(
    1, current_setting('my.movies_count')::int
) as id;

-- 6. Киносеансы
INSERT INTO sessions (
    movie_id, hall_id, date,
    start_time, finish_time, price
)
SELECT
    random_between(1, current_setting('my.movies_count')::int),
    random_between(1, current_setting('my.halls_count')::int),
    random_timestamp(current_setting('my.start_date')::timestamp, NOW()),
    random_timestamp(current_setting('my.start_date')::timestamp, NOW()),
    random_timestamp(current_setting('my.start_date')::timestamp, NOW()),
    random_between(200, 1600)
FROM GENERATE_SERIES(
    1, current_setting('my.sessions_count')::int
) as id;

-- 7. Клиенты
INSERT INTO clients (firstname, lastname, email, phone, birth_date)
SELECT
    concat('Firstname ', id),
    concat('Lastname ', id),
    concat('email', id, '@example.com'),
    random_between(9210000000, 9999999999),
    random_timestamp(current_setting('my.start_date')::timestamp, NOW())
FROM GENERATE_SERIES(
    1, current_setting('my.sessions_count')::int
) as id;

-- 8. Билеты
INSERT INTO tickets (session_id, seat_id, client_id, is_paid)
SELECT
    random_between(1, current_setting('my.sessions_count')::int),
    random_between(1, current_setting('my.seats_count')::int),
    random_between(1, current_setting('my.clients_count')::int),
    random() > 0.5
FROM GENERATE_SERIES(
    1, current_setting('my.tickets_count')::int
) as id;
