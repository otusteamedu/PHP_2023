CREATE DATABASE IF NOT EXISTS cinema_database;
CREATE USER IF NOT EXISTS cinema_user@localhost IDENTIFIED BY 'cinema_password12S34~d~~';
GRANT ALL PRIVILEGES ON cinema_database.* TO cinema_user@localhost;
USE cinema_database;

CREATE TABLE IF NOT EXISTS films
(
    id               INT(11)      NOT NULL AUTO_INCREMENT,
    name             VARCHAR(255) NOT NULL,
    film_description TEXT,
    duration         INT(11),
    price            DECIMAL(11, 2),
    age_rating       TINYINT,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS zones
(
    id          INT(11)      NOT NULL AUTO_INCREMENT,
    name        VARCHAR(255) NOT NULL,
    coefficient DECIMAL(4, 2) DEFAULT 1.00,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS session_types
(
    id          INT(11)      NOT NULL AUTO_INCREMENT,
    name        VARCHAR(255) NOT NULL,
    coefficient DECIMAL(4, 2) DEFAULT 1.00,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS hall_types
(
    id          INT(11)      NOT NULL AUTO_INCREMENT,
    name        VARCHAR(255) NOT NULL,
    coefficient DECIMAL(4, 2) DEFAULT 1.00,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS viewers
(
    id        INT(11)      NOT NULL AUTO_INCREMENT,
    full_name VARCHAR(255) NOT NULL,
    age       TINYINT,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS halls
(
    id          INT(11)      NOT NULL AUTO_INCREMENT,
    name        VARCHAR(255) NOT NULL,
    coefficient DECIMAL(4, 2) DEFAULT 1.00,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS hall_types_halls
(
    id           INT(11) NOT NULL AUTO_INCREMENT,
    hall_id      INT(11),
    hall_type_id INT(11),
    PRIMARY KEY (id),
    FOREIGN KEY (hall_id) REFERENCES halls (id),
    FOREIGN KEY (hall_type_id) REFERENCES hall_types (id)
);

CREATE TABLE IF NOT EXISTS sessions
(
    id           INT(11) NOT NULL AUTO_INCREMENT,
    session_type INT(11),
    hall_id      INT(11),
    film_id      INT(11),
    time_start   DATETIME,
    time_end     DATETIME,
    PRIMARY KEY (id),
    FOREIGN KEY (hall_id) REFERENCES halls (id),
    FOREIGN KEY (film_id) REFERENCES films (id),
    FOREIGN KEY (session_type) REFERENCES session_types (id)
);

CREATE TABLE IF NOT EXISTS seats
(
    id       INT(11) NOT NULL AUTO_INCREMENT,
    seat_num INT(4),
    row_num  INT(4),
    zone_id  INT(11),
    PRIMARY KEY (id),
    FOREIGN KEY (zone_id) REFERENCES zones (id)
);

CREATE TABLE IF NOT EXISTS tickets
(
    id         INT(11) NOT NULL AUTO_INCREMENT,
    seat_id    INT(11),
    viewer_id  INT(11),
    session_id INT(11),
    PRIMARY KEY (id),
    FOREIGN KEY (seat_id) REFERENCES seats (id),
    FOREIGN KEY (viewer_id) REFERENCES viewers (id),
    FOREIGN KEY (session_id) REFERENCES sessions (id)
);

