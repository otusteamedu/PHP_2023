CREATE TABLE IF NOT EXISTS cinema
(
    id   SERIAL PRIMARY KEY,
    name   VARCHAR(255)                                        NOT NULL,
    status INTEGER DEFAULT 1                                   NOT NULL
);

INSERT INTO cinema (id, name) VALUES (1, 'first cinema');

-- #####################################################################################################################

CREATE TABLE IF NOT EXISTS halls
(
    id   SERIAL PRIMARY KEY,
    name        VARCHAR(255)      NOT NULL,
    status      INTEGER DEFAULT 1 NOT NULL,
    cinema_id   INTEGER           NOT NULL
    constraint halls_to_cinema_fk references cinema (id)
);

INSERT INTO halls (id, name, cinema_id)
VALUES (1, 'Красный', 1),
       (2, 'Зеленый', 1);

-- #####################################################################################################################

CREATE TABLE IF NOT EXISTS movies
(
    id          SERIAL PRIMARY KEY,
    name        VARCHAR(255),
    age         INTEGER,
    description TEXT,
    poster      VARCHAR(255),
    trailer     VARCHAR,
    duration    TIME,
    date_start  DATE,
    date_end    DATE,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);

INSERT INTO movies (name, age, description, poster, trailer, duration, date_start, date_end)
VALUES ('Movie 1', '18', null, null, null, '02:00:00', '2023-09-24', '2023-10-24'),
       ('Movie 2', '16', null, null, null, '02:00:00', '2023-09-24', '2023-10-24'),
       ('Movie 3', '14', null, null, null, '02:00:00', '2023-09-24', '2023-10-24'),
       ('Movie 4', '12', null, null, null, '02:00:00', '2023-09-24', '2023-10-24'),
       ('Movie 5', '18', null, null, null, '02:00:00', '2023-09-24', '2023-10-24');

-- #####################################################################################################################

CREATE TABLE IF NOT EXISTS seats
(
    id   SERIAL PRIMARY KEY,
    row     INTEGER NOT NULL,
    place   INTEGER NOT NULL,
    hall_id INTEGER NOT NULL
    constraint seats_halls_id_fk references halls (id)
);

INSERT INTO seats (row, place, hall_id)
VALUES (1, 1, 1),
       (1, 2, 1),
       (1, 3, 1),
       (1, 4, 1),
       (1, 5, 1),
       (1, 1, 2),
       (1, 2, 2),
       (1, 3, 2),
       (1, 4, 2),
       (1, 5, 2),
       (2, 1, 2),
       (2, 2, 2),
       (2, 3, 2),
       (2, 4, 2),
       (2, 5, 2);

-- #####################################################################################################################

CREATE TABLE IF NOT EXISTS sessions
(
    id   SERIAL PRIMARY KEY,
    time_start time                                NOT NULL,
    time_end   time                                NOT NULL,
    movie_id   INTEGER                             NOT NULL
    constraint sessions_movies_id_fk references movies (id),
    hall_id    INTEGER                             NOT NULL
    constraint sessions_halls_id_fk references halls (id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);

INSERT INTO sessions (time_start, time_end, movie_id, hall_id)
VALUES ('12:00:00', '14:00:00', 1, 1),
       ('12:00:00', '14:00:00', 2, 2),
       ('14:00:00', '16:00:00', 3, 1),
       ('14:00:00', '16:00:00', 4, 2),
       ('16:00:00', '18:00:00', 5, 1);

-- #####################################################################################################################

CREATE TABLE IF NOT EXISTS tickets
(
    id   SERIAL PRIMARY KEY,
    seat_id    INTEGER           NOT NULL
    constraint tickets_seats_id_fk references seats (id),
    session_id INTEGER           NOT NULL
    constraint tickets_sessions_id_fk references sessions (id),
    price      double precision  NOT NULL,
    status     INTEGER DEFAULT 0 NOT NULL,
    purchased_at TIMESTAMP DEFAULT NULL
);

INSERT INTO tickets (seat_id, session_id, price, status)
VALUES (1, 1, 300, 1),
       (2, 1, 300, 1),
       (3, 1, 300, 1),
       (4, 1, 300, 1),
       (1, 2, 300, 1),
       (2, 2, 300, 1),
       (1, 3, 300, 1),
       (2, 3, 300, 1),
       (1, 4, 300, 1),
       (1, 5, 300, 1);

-- #####################################################################################################################

CREATE TABLE IF NOT EXISTS genres
(
    id   SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

-- #####################################################################################################################

CREATE TABLE IF NOT EXISTS actors
(
    id   SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

-- #####################################################################################################################

CREATE TABLE IF NOT EXISTS movies_to_genres
(
    movie_id INTEGER NOT NULL
        constraint movies_to_genres_movies_id_fk
        references movies (id),
    genre_id INTEGER NOT NULL
        constraint movies_to_genres_genres_id_fk
        references genres (id)
);

-- #####################################################################################################################

CREATE TABLE IF NOT EXISTS movies_to_actors
(
    movie_id INTEGER NOT NULL
        constraint movies_to_actors_movies_id_fk
        references movies (id),
    actor_id INTEGER NOT NULL
        constraint movies_to_actors_actors_id_fk
        references actors (id)
);

-- #####################################################################################################################

SELECT m.name, SUM(t.price) as price
FROM tickets t
    INNER JOIN sessions s ON t.session_id = s.id
    INNER JOIN movies m ON s.movie_id = m.id
WHERE t.status = 1
GROUP BY m.name
ORDER BY price DESC;
