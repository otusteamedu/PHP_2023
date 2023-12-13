CREATE TABLE genres (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL
);

CREATE TABLE films (
    id SERIAL PRIMARY KEY,
    genre_id INT NULL,
    title VARCHAR(255) NOT NULL,
    FOREIGN KEY (genre_id)
        REFERENCES genres (id) ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE halls (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL
);

CREATE TABLE seats (
    id SERIAL PRIMARY KEY,
    hall_id INT NOT NULL,
    row INT NOT NULL,
    number INT NOT NULL,
    FOREIGN KEY (hall_id)
        REFERENCES halls (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE sessions (
    id SERIAL PRIMARY KEY,
    hall_id INT NOT NULL,
    film_id INT NOT NULL,
    date DATE,
    time TIME,
    FOREIGN KEY (hall_id)
        REFERENCES halls (id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (film_id)
        REFERENCES films (id) ON UPDATE CASCADE ON DELETE CASCADE

);

CREATE TABLE prices (
   id SERIAL PRIMARY KEY,
   session_id INT NOT NULL,
   price FLOAT NOT NULL,
   FOREIGN KEY (session_id)
       REFERENCES sessions (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE clients (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NULL,
    birthday DATE NULL
);

CREATE TABLE tickets (
    id SERIAL PRIMARY KEY,
    client_id INT NULL,
    session_id INT NOT NULL,
    seat_id INT NOT NULL,
    cost NUMERIC,
    FOREIGN KEY (client_id)
        REFERENCES clients (id) ON UPDATE CASCADE ON DELETE SET NULL,
    FOREIGN KEY (session_id)
        REFERENCES sessions (id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (seat_id)
        REFERENCES seats (id) ON UPDATE CASCADE ON DELETE CASCADE
);
