-- Параметры
SET SESSION my.cinemas_count = '5';
SET SESSION my.genres_count = '5';
SET SESSION my.movies_count = '5';
SET SESSION my.clients_count = '5';

SET SESSION my.start_date = '1941-01-01';

-- 1. Фильмы
INSERT INTO cinemas (title, description, address, thumbnail, halls_count)
SELECT
    concat('Cinema ', number),
    concat('Cinema ', number, ' description'),
    concat('Cinema ', number, ' address'),
    concat('/cinemas/', number, '/thumbnail.webp'),
    random_between(10, 50)
FROM
    GENERATE_SERIES(1, current_setting('my.cinemas_count')::int) as number;

-- 2. Кинозалы
INSERT INTO halls (cinema_id, title, seats_count)
SELECT
    cinema.id,
    concat('Hall ', number),
    random_between(100, 800)
FROM
    GENERATE_SERIES(1, 3) as number,
    (SELECT id FROM cinemas) as cinema;

-- 3. Места
INSERT INTO seats (hall_id, row, number)
SELECT
    hall.id,
    random_between(1, 35),
    number
FROM
    GENERATE_SERIES(1, 3) as number,
    (SELECT id FROM halls) as hall;

-- 4. Жанры
INSERT INTO genres (title, description)
SELECT
    concat('Genre ', number),
    concat('Genre ', number, ' description')
FROM
    GENERATE_SERIES(1, current_setting('my.genres_count')::int) as number;

-- 5. Фильмы
INSERT INTO movies (
    genre_id, title, description, duration,
    release_date, rental_start,
    rental_finish, rating, thumbnail
)
SELECT
    genre.id,
    concat('Movie ', number),
    concat('Movie ', number, ' description'),
    random_between(60, 200),
    random_timestamp(current_setting('my.start_date')::timestamp, NOW()),
    random_timestamp(current_setting('my.start_date')::timestamp, NOW()),
    random_timestamp(current_setting('my.start_date')::timestamp, NOW()),
    random() * 10,
    concat('/movies/', number, '/thumbnail.webp')
FROM
    GENERATE_SERIES(1, current_setting('my.movies_count')::int) as number,
    (SELECT id FROM genres) as genre;

-- 6. Киносеансы
INSERT INTO sessions (movie_id, hall_id, date,start_time, finish_time)
SELECT
    movie.id,
    hall.id,
    random_timestamp(current_setting('my.start_date')::timestamp, NOW()),
    random_timestamp(current_setting('my.start_date')::timestamp, NOW()),
    random_timestamp(current_setting('my.start_date')::timestamp, NOW())
FROM
    (SELECT id FROM movies) as movie,
    (SELECT id FROM halls) as hall;

-- 7. Клиенты
INSERT INTO clients (firstname, lastname, email, phone, birth_date)
SELECT
    concat('Firstname ', number),
    concat('Lastname ', number),
    concat('email', number, '@example.com'),
    random_between(9210000000, 9999999999),
    random_timestamp(current_setting('my.start_date')::timestamp, NOW())
FROM
    GENERATE_SERIES(1, current_setting('my.clients_count')::int) as number;

-- 8. Билеты
INSERT INTO tickets (session_id, seat_id, client_id, price, is_paid)
SELECT
    session.id,
    seat.id,
    client.id,
    random_between(200, 1600),
    random() > 0.5
FROM
    (SELECT id FROM sessions) as session,
    (SELECT id FROM seats) as seat,
    (SELECT id FROM clients) as client;
