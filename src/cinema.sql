CREATE TABLE IF NOT EXISTS hall
(
    id SERIAL PRIMARY KEY,
    name CHARACTER VARYING(255) NOT NULL,
    capacity SMALLINT NOT NULL,
    description TEXT
);

CREATE TABLE IF NOT EXISTS hall_schema
(
    id SERIAL PRIMARY KEY,
    rows SMALLINT NOT NULL,
    seats SMALLINT NOT NULL,
    hall_id SERIAL REFERENCES hall (id)
);

CREATE TABLE IF NOT EXISTS movie
(
    id SERIAL PRIMARY KEY,
    name CHARACTER VARYING(255),
    director CHARACTER VARYING(255),
    genre CHARACTER VARYING(255),
    duration SMALLINT
);

CREATE TABLE IF NOT EXISTS showtime
(
    id SERIAL PRIMARY KEY,
    hall_id SERIAL REFERENCES hall (id),
    movie_id SERIAL REFERENCES movie (id),
    start_time TIMESTAMP,
    end_time TIMESTAMP,
    price DECIMAL(8, 2)
);

CREATE TABLE IF NOT EXISTS customer
(
    id SERIAL PRIMARY KEY,
    first_name CHARACTER VARYING(255),
    last_name CHARACTER VARYING(255),
    email CHARACTER VARYING(255),
    phone CHARACTER VARYING(20)
);

CREATE TABLE IF NOT EXISTS ticket
(
    id SERIAL PRIMARY KEY,
    showtime_id SERIAL REFERENCES showtime (id),
    customer_id SERIAL REFERENCES customer (id),
    row SMALLINT,
    seat SMALLINT,
    price DECIMAL(8, 2)
);
