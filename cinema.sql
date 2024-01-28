CREATE SCHEMA theater collate utf8mb4_unicode_ci;

CREATE TABLE films
(
    id   INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE halls
(
    id       INT AUTO_INCREMENT PRIMARY KEY,
    name     VARCHAR(100) NOT NULL,
    capacity INT          NOT NULL
);

CREATE TABLE places
(
    id           INT AUTO_INCREMENT PRIMARY KEY,
    place_number INT NOT NULL,
    row          INT NOT NULL,
    hall_id      INT NOT NULL,
    CONSTRAINT places_halls_id_fk FOREIGN KEY (hall_id) REFERENCES halls (id)
);

CREATE TABLE seances
(
    id      INT AUTO_INCREMENT PRIMARY KEY,
    hall_id INT NOT NULL,
    film_id INT NOT NULL,
    start   TIMESTAMP NULL,
    end     TIMESTAMP NULL,
    CONSTRAINT seances_films_id_fk FOREIGN KEY (film_id) REFERENCES films (id),
    CONSTRAINT seances_halls_id_fk FOREIGN KEY (hall_id) REFERENCES halls (id)
);

CREATE TABLE tickets
(
    id        INT AUTO_INCREMENT PRIMARY KEY,
    seance_id INT NOT NULL,
    place_id  INT NULL,
    price     INT NOT NULL,
    CONSTRAINT tickets_places_id_fk FOREIGN KEY (place_id) REFERENCES places (id),
    CONSTRAINT tickets_seances_id_fk FOREIGN KEY (seance_id) REFERENCES seances (id)
);

CREATE TABLE peoples
(
    id    INT AUTO_INCREMENT PRIMARY KEY,
    name  VARCHAR(100) NOT NULL,
    phone VARCHAR(20)  NOT NULL,
    email VARCHAR(30)  NOT NULL
);

CREATE TABLE orders
(
    id        INT AUTO_INCREMENT PRIMARY KEY,
    user_id   INT NOT NULL,
    ticket_id INT NOT NULL,
    CONSTRAINT orders_tickets_id_fk FOREIGN KEY (ticket_id) REFERENCES tickets (id),
    CONSTRAINT orders_peoples_id_fk FOREIGN KEY (user_id) REFERENCES peoples (id)
);