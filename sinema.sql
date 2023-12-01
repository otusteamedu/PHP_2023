CREATE TABLE customers
(
    id    SERIAL PRIMARY KEY,
    name  CHARACTER VARYING(255),
    phone CHARACTER VARYING(20)
);

CREATE TABLE movies
(
    id       SERIAL PRIMARY KEY,
    name     CHARACTER VARYING(255),
    duration SMALLINT
);

CREATE TABLE halls
(
    id          SERIAL PRIMARY KEY,
    name        CHARACTER VARYING(255) NOT NULL,
    description TEXT
);

CREATE TABLE seats_in_halls
(
    id      SERIAL PRIMARY KEY,
    hall_id SERIAL REFERENCES halls (id),
    row     SMALLINT NOT NULL,
    seats   SMALLINT NOT NULL
);

CREATE TABLE showtime
(
    id         SERIAL PRIMARY KEY,
    movie_id   SERIAL REFERENCES movies (id),
    hall_id    SERIAL REFERENCES halls (id),
    start_time TIMESTAMP,
    end_time   TIMESTAMP
);

CREATE TABLE tickets
(
    id              SERIAL PRIMARY KEY,
    price           DECIMAL(8, 2),
    showtime_id     SERIAL REFERENCES showtime (id),
    customer_id     SERIAL REFERENCES customers (id),
    seat_in_hall_id SERIAL REFERENCES customers (id)
);
