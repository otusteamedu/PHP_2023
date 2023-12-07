CREATE TABLE halls
(
    hall_id  SERIAL PRIMARY KEY,
    title    VARCHAR(50),
    capacity INT
);

CREATE TABLE genres
(
    genre_id SERIAL PRIMARY KEY,
    title    VARCHAR(50)
);

CREATE TABLE movies
(
    movie_id SERIAL PRIMARY KEY,
    genre_id INT,
    title    VARCHAR(255),
    duration INT,
    rating   INT,
    FOREIGN KEY (genre_id) REFERENCES genres (genre_id)
);

CREATE TABLE seances
(
    seance_id  SERIAL PRIMARY KEY,
    hall_id    INT,
    movie_id   INT,
    base_price DECIMAL(10, 2),
    start_time TIMESTAMP,
    FOREIGN KEY (hall_id) REFERENCES halls (hall_id),
    FOREIGN KEY (movie_id) REFERENCES movies (movie_id)
);

CREATE TABLE type_seats
(
    type_seats_id SERIAL PRIMARY KEY,
    title         VARCHAR(50)
);

CREATE TABLE seats
(
    seat_id        SERIAL PRIMARY KEY,
    hall_id        INT,
    type_seats_id  INT,
    seat_number    INT,
    number_row     INT,
    price_modifier DECIMAL(3, 2),
    FOREIGN KEY (hall_id) REFERENCES halls (hall_id),
    FOREIGN KEY (type_seats_id) REFERENCES type_seats (type_seats_id)
);

CREATE TABLE tickets
(
    ticket_id      SERIAL PRIMARY KEY,
    seance_id      INT,
    seat_id        INT,
    price          DECIMAL(10, 2),
    purchased_time TIMESTAMP,
    FOREIGN KEY (seance_id) REFERENCES seances (seance_id),
    FOREIGN KEY (seat_id) REFERENCES seats (seat_id)
);