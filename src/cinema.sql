CREATE TABLE hall
(
    id SERIAL PRIMARY KEY,
    name CHARACTER VARYING(255) NOT NULL,
    capacity SMALLINT NOT NULL,
    description TEXT
);

CREATE TABLE hall_row
(
    id SERIAL PRIMARY KEY,
    seats SMALLINT NOT NULL,
    hall_id INT NOT NULL REFERENCES hall (id)
);

CREATE TABLE movie
(
    id SERIAL PRIMARY KEY,
    name CHARACTER VARYING(255) NOT NULL,
    director CHARACTER VARYING(255) NOT NULL,
    genre CHARACTER VARYING(255) NOT NULL,
    duration SMALLINT NOT NULL
);

CREATE TABLE showtime
(
    id SERIAL PRIMARY KEY,
    hall_id INT REFERENCES hall (id),
    movie_id INT REFERENCES movie (id),
    start_time TIMESTAMP,
    duration INT NOT NULL,
    price DECIMAL(8, 2)
);

CREATE TABLE customer
(
    id SERIAL PRIMARY KEY,
    first_name CHARACTER VARYING(255),
    last_name CHARACTER VARYING(255),
    email CHARACTER VARYING(255),
    phone CHARACTER VARYING(20)
);

CREATE TABLE ticket
(
    id SERIAL PRIMARY KEY,
    showtime_id INT REFERENCES showtime (id),
    customer_id INT REFERENCES customer (id),
    row SMALLINT,
    seat SMALLINT,
    price DECIMAL(8, 2),
    sale_date TIMESTAMP
);
