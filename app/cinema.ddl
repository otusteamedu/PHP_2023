CREATE TABLE hall (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    scheme_id SERIAL NOT NULL
);

CREATE TABLE hall_scheme (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE session (
    id SERIAL PRIMARY KEY,
    hall_id SERIAL NOT NULL,
    movie_id SERIAL NOT NULL,
    time_type SERIAL NOT NULL,
    start_date TIMESTAMP NOT NULL,
    end_date TIMESTAMP NOT NULL,
    UNIQUE (hall_id, movie_id, time_type)
);

CREATE TABLE movie (
    id SERIAL PRIMARY KEY,
    name VARCHAR(1000) NOT NULL,
    duration INT NOT NULL
);

CREATE TABLE time_type (
    id SERIAL PRIMARY KEY,
    start_time time NOT NULL UNIQUE,
    description VARCHAR(255)
);

CREATE TABLE seat (
    id SERIAL PRIMARY KEY,
    number SMALLINT NOT NULL,
    row SMALLINT NOT NULL,
    scheme_id SERIAL NOT NULL,
    seat_type SERIAL NOT NULL,
    UNIQUE (number, row, scheme_id, seat_type)
);

CREATE TABLE seat_type (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE price (
    id SERIAL PRIMARY KEY,
    scheme_id SERIAL NOT NULL,
    seat_type SERIAL NOT NULL,
    time_type SERIAL NOT NULL,
    price DECIMAL NOT NULL DEFAULT 0,
    UNIQUE (scheme_id, seat_type, time_type)
);

CREATE TABLE client (
    id SERIAL PRIMARY KEY,
    phone VARCHAR(15) NOT NULL UNIQUE,
    first_name VARCHAR(255),
    last_name VARCHAR(255)
);

CREATE TABLE ticket (
    id SERIAL PRIMARY KEY,
    session_id SERIAL NOT NULL,
    seat_id SERIAL NOT NULL,
    client_id SERIAL,
    date TIMESTAMP NOT NULL,
    amount DECIMAL NOT NULL DEFAULT 0,
    UNIQUE (session_id, seat_id)
);

ALTER TABLE hall
  ADD CONSTRAINT hall_scheme_id_fk FOREIGN KEY (scheme_id) REFERENCES hall_scheme (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE session
  ADD CONSTRAINT session_scheme_id_fk FOREIGN KEY (hall_id) REFERENCES hall (id) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT session_movie_id_fk FOREIGN KEY (movie_id) REFERENCES movie (id) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT session_time_type_fk FOREIGN KEY (time_type) REFERENCES time_type (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE seat
    ADD CONSTRAINT seat_scheme_id_fk FOREIGN KEY (scheme_id) REFERENCES hall_scheme (id) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT seat_seat_type_fk FOREIGN KEY (seat_type) REFERENCES seat_type (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE price
    ADD CONSTRAINT price_scheme_id_fk FOREIGN KEY (scheme_id) REFERENCES hall_scheme (id) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT price_seat_type_fk FOREIGN KEY (seat_type) REFERENCES seat_type (id) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT price_time_type_fk FOREIGN KEY (time_type) REFERENCES time_type (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE ticket
    ADD CONSTRAINT ticket_session_id_fk FOREIGN KEY (session_id) REFERENCES session (id) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT ticket_seat_id_fk FOREIGN KEY (seat_id) REFERENCES seat (id) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT ticket_client_id_fk FOREIGN KEY (client_id) REFERENCES client (id) ON DELETE SET NULL ON UPDATE CASCADE;
