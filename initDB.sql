
CREATE DATABASE IF NOT EXISTS cinema_app;

CREATE TABLE halls (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    capacity INT NOT NULL,
    PRIMARY KEY(id)
)

CREATE TABLE places (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    seat_row INT NOT NULL,
    hall_id INT NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(hall_id) REFERENCES halls(id)
)

CREATE TABLE movies (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    PRIMARY KEY(id)
)


CREATE TABLE seances (
    id INT NOT NULL AUTO_INCREMENT,
    hall_id INT NOT NULL,
    movie_id INT NOT NULL,
    start TIMESTAMP,
    end TIMESTAMP,
    PRIMARY KEY(id),
    FOREIGN KEY(hall_id) REFERENCES halls(id),
    FOREIGN KEY(movie_id) REFERENCES movies(id),
)

CREATE TABLE  tickets (
    id INT NOT NULL AUTO_INCREMENT,
    seance_id INT NOT NULL,
    place_id INT NOT NULL,
    price INT,
    PRIMARY KEY(id),
    FOREIGN KEY(place_id) REFERENCES places(id),
    FOREIGN KEY(seance_id) REFERENCES seances(id)
)

CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR NOT NULL,
)


CREATE TABLE user_ticket (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    ticket_id INT NOT NULL,
    status INT,
    PRIMARY KEY(id),
    FOREIGN KEY(user_id) REFERENCES users,
    FOREIGN KEY(ticket_id) REFERENCES tickets
)

