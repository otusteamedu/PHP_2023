CREATE TABLE halls
(
    id   SERIAL PRIMARY KEY,
    name VARCHAR(20) NOT NULL
);

CREATE TABLE price_seat_modificators
(
    id    SERIAL PRIMARY KEY,
    name  VARCHAR(20) NOT NULL,
    price INTEGER     NOT NULL,
);

CREATE TABLE seats
(
    id                        SERIAL PRIMARY KEY,
    hall_id                   INTEGER NOT NULL,
    price_seat_modificator_id INTEGER NOT NULL,
    column                    INTEGER NOT NULL,
    row                       INTEGER NOT NULL,

    FOREIGN KEY (hall_id) REFERENCES halls (id),
    FOREIGN KEY (price_seat_modificator_id) REFERENCES price_seat_modificators (id),
);

CREATE TABLE movies
(
    id    SERIAL PRIMARY KEY,
    name  VARCHAR(255) NOT NULL,
    price INTEGER      NOT NULL
);


CREATE TABLE price_seance_modificators
(
    id    SERIAL PRIMARY KEY,
    name  VARCHAR(20) NOT NULL,
    price INTEGER     NOT NULL
);


CREATE TABLE users
(
    id    SERIAL PRIMARY KEY,
    email VARCHAR(20) NOT NULL
);

CREATE TABLE seances
(
    id                          SERIAL PRIMARY KEY,
    hall_id                     INTEGER NOT NULL,
    movie_id                    INTEGER NOT NULL,
    price_seance_modificator_id INTEGER NOT NULL,
    date_start                  TIMESTAMP,

    FOREIGN KEY (hall_id) REFERENCES halls (id),
    FOREIGN KEY (movie_id) REFERENCES movies (id),
    FOREIGN KEY (price_seance_modificator_id) REFERENCES price_seance_modificators (id),

);

CREATE TABLE tickets
(
    id      serial primary key,
    seat_id integer not null,
    seance_id  integer not null,
    user_id integer not null,
    price   integer not null,

    FOREIGN KEY (seat_id) REFERENCES seats (id),
    FOREIGN KEY (seance_id) REFERENCES seances (id),
    FOREIGN KEY (user_id) REFERENCES users (id),
);
