-- Параметры
SET SESSION my.cinemas_count = '15';
SET SESSION my.genres_count = '15';
SET SESSION my.movies_count = '15';
SET SESSION my.clients_count = '15';
-- 20.5 Млн билетов

SET SESSION my.start_date = '2022-01-01';

-- 1. Кинотеатры
INSERT INTO cinemas (title, description, address, thumbnail, halls_count)
SELECT
    concat('Cinema ', random_word(5)),
    concat('Cinema ', random_word(5), ' description'),
    concat('Cinema ', random_word(5), ' address'),
    concat('/cinemas/', random_word(5), '/thumbnail.webp'),
    random_between(10, 50)
FROM
    GENERATE_SERIES(1, current_setting('my.cinemas_count')::int) as number;

-- 2. Кинозалы
INSERT INTO halls (cinema_id, title, seats_count)
SELECT
    cinema.id,
    concat('Hall ', random_word(5)),
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
    concat('Genre ', random_word(5)),
    concat('Genre ', random_word(5), ' description')
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
    concat('Movie ', random_word(5)),
    concat('Movie ', random_word(5), ' description'),
    random_between(60, 200),
    random_timestamp(current_setting('my.start_date')::timestamptz, NOW()),
    random_timestamp(current_setting('my.start_date')::timestamptz, NOW()),
    random_timestamp(current_setting('my.start_date')::timestamptz, NOW()),
    random() * 10,
    concat('/movies/', random_word(5), '/thumbnail.webp')
FROM
    GENERATE_SERIES(1, current_setting('my.movies_count')::int) as number,
    (SELECT id FROM genres) as genre;

-- 6. Киносеансы
INSERT INTO sessions (movie_id, hall_id, date, start_time, finish_time)
SELECT
    movie.id,
    hall.id,
    random_timestamp(NOW() - INTERVAL '2 WEEK', NOW() + INTERVAL '2 MONTH'),
    random_timestamp(current_setting('my.start_date')::timestamptz, NOW()),
    random_timestamp(current_setting('my.start_date')::timestamptz, NOW())
FROM
    (SELECT id FROM movies) as movie,
    (SELECT id FROM halls) as hall;

-- 7. Клиенты
INSERT INTO clients (firstname, lastname, email, phone, birth_date)
SELECT
    concat('Firstname ', random_word(5)),
    concat('Lastname ', random_word(5)),
    concat('email', random_word(5), '@example.com'),
    random_between(9210000000, 9999999999),
    random_timestamp(current_setting('my.start_date')::timestamptz, NOW())
FROM
    GENERATE_SERIES(1, current_setting('my.clients_count')::int) as number;

-- 8. Билеты
INSERT INTO tickets (session_id, seat_id, client_id, price, paid_at)
SELECT
    session.id,
    seat.id,
    client.id,
    random_between(200, 1600),
    (session.date + INTERVAL '14 HOURS')::timestamptz
FROM
    (SELECT id, date FROM sessions) as session,
    (SELECT id FROM seats) as seat,
    (SELECT id FROM clients) as client;

-- 9. Типы атрибутов
INSERT INTO
    attribute_types(type)
VALUES
    ('TEXT'),
    ('BOOL'),
    ('DATE');

-- 10. Атрибуты
INSERT INTO attributes
    (parent_id, attribute_type_id, title)
VALUES
    (NULL, 1, 'Рецензии'),
    (1, 1, 'Рецензия кинокритика'),
    (1, 1, 'Рецензия киноакадемии'), --3
    (NULL, 2, 'Премии'),
    (4, 2, 'Оскар'),
    (4, 2, 'Ника'), --6
    (NULL, 3, 'Важные даты'),
    (7, 3, 'Мировая премьера'),
    (7, 3, 'Премьера в России'), --9
    (NULL, 3, 'Служебные даты'),
    (10, 3, 'Дата начала продажи'),
    (10, 3, 'Дата запуска рекламы'); --12

/*

10. Атрибуты
10.1 Рецензии

*/
INSERT INTO values
    (movie_id, attribute_id, text)
SELECT
    movie.id,
    2,
    'Текст рецензии кинокритика'
FROM
    (SELECT id FROM movies) as movie;

INSERT INTO values
    (movie_id, attribute_id, text)
SELECT
    movie.id,
    3,
    'Текст рецензии киноакадемии'
FROM
    (SELECT id FROM movies) as movie;

-- 10.2 Премии
INSERT INTO values
    (movie_id, attribute_id, bool)
SELECT
    movie.id,
    5,
    round(random())::int::boolean --true/false random value
FROM
    (SELECT id FROM movies) as movie;

INSERT INTO values
    (movie_id, attribute_id, bool)
SELECT
    movie.id,
    6,
    round(random())::int::boolean --true/false random value
FROM
    (SELECT id FROM movies) as movie;

-- 10.3 Важные даты
INSERT INTO values
    (movie_id, attribute_id, date)
SELECT
    movie.id,
    8,
    random_timestamp(current_setting('my.start_date')::timestamptz, NOW())
FROM
    (SELECT id FROM movies) as movie;

INSERT INTO values
    (movie_id, attribute_id, date)
SELECT
    movie.id,
    9,
    random_timestamp(current_setting('my.start_date')::timestamptz, NOW())
FROM
    (SELECT id FROM movies) as movie;

-- 10.4 Служебные даты
INSERT INTO values
    (movie_id, attribute_id, date)
SELECT
    movie.id,
    11,
    random_timestamp(
        NOW(),
        NOW() + INTERVAL '20 DAY'
    )
FROM
    (SELECT id FROM movies) as movie;

INSERT INTO values
    (movie_id, attribute_id, date)
SELECT
    movie.id,
    12,
    random_timestamp(
        NOW(),
        NOW() + INTERVAL '20 DAY'
    )
FROM
    (SELECT id FROM movies) as movie;
