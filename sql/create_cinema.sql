DROP TABLE IF EXISTS films CASCADE;
DROP TABLE IF EXISTS attributes CASCADE;
DROP TABLE IF EXISTS attribute_values CASCADE;
DROP TABLE IF EXISTS halls CASCADE;
DROP TABLE IF EXISTS places CASCADE;
DROP TABLE IF EXISTS clients CASCADE;
DROP TABLE IF EXISTS sessions CASCADE;
DROP TABLE IF EXISTS prices CASCADE;
DROP TABLE IF EXISTS session_place_price CASCADE;
DROP TABLE IF EXISTS tickets CASCADE;

CREATE TABLE films (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    release_date DATE NOT NULL
);

CREATE TABLE attributes (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE attribute_values (
    id SERIAL PRIMARY KEY,
    film_id INT NOT NULL,
    attribute_id INT NOT NULL,
    text_value TEXT,
    integer_value INT,
    decimal_value DECIMAL(10, 2),
    date_value DATE,
    boolean_value BOOLEAN,
    FOREIGN KEY (film_id) REFERENCES films (id),
    FOREIGN KEY (attribute_id) REFERENCES attributes (id)
);

CREATE TABLE halls (
    id SERIAL PRIMARY KEY,
    number INT NOT NULL
);

CREATE TABLE places (
    id SERIAL PRIMARY KEY,
    row_number INT NOT NULL,
    place INT NOT NULL,
    hall_id INT NOT NULL,
    FOREIGN KEY (hall_id) REFERENCES halls (id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE clients (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    surname VARCHAR(255) NOT NULL,
    phone VARCHAR(255) NOT NULL
);

CREATE TABLE sessions (
    id SERIAL PRIMARY KEY,
    date_start DATE NOT NULL,
    time_start TIME NOT NULL,
    hall_id INT NOT NULL,
    film_id INT NOT NULL,
    FOREIGN KEY (hall_id) REFERENCES halls (id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (film_id) REFERENCES films (id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE prices (
    id SERIAL PRIMARY KEY,
    price DECIMAL(10,2) NOT NULL
);

CREATE TABLE session_place_price (
    id SERIAL PRIMARY KEY,
    place_id INT NOT NULL,
    price_id INT NOT NULL,
    session_id INT NOT NULL,
    FOREIGN KEY (place_id) REFERENCES places (id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (price_id) REFERENCES prices (id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (session_id) REFERENCES sessions (id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE tickets (
    id SERIAL PRIMARY KEY,
    final_price DECIMAL(10,2) NOT NULL,
    client_id INT NULL,
    film_id INT NOT NULL,
    sold_date DATE NOT NULL,
    sold_time TIME NOT NULL,
    session_place_price_id INT NOT NULL,
    FOREIGN KEY (client_id) REFERENCES clients (id) ON UPDATE CASCADE,
    FOREIGN KEY (film_id) REFERENCES films (id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (session_place_price_id) REFERENCES session_place_price (id) ON DELETE CASCADE ON UPDATE CASCADE
);
