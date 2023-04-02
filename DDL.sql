/*
 * Кинотеатр имеет несколько залов, в каждом зале идет несколько разных сеансов, клиенты могут купить билеты на сеансы
*/

/* Залы */
CREATE TABLE hall
(
    id   serial PRIMARY KEY,
    name varchar(255) NOT NULL,
    PRIMARY KEY (id)
);

/* Места */
CREATE TABLE place
(
    id      serial PRIMARY KEY,
    hall_id int NOT NULL,
    row     int NOT NULL,
    place   int NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT FK_place_hall FOREIGN KEY (hall_id) REFERENCES hall (id) ON DELETE CASCADE ON UPDATE CASCADE
);

/* Фильмы */
CREATE TABLE movie
(
    id         serial PRIMARY KEY,
    name       varchar(255) NOT NULL,
    start_date date         NOT NULL,
    duration   int NOT NULL DEFAULT '0',
    PRIMARY KEY (id)
);

/* Сеансы */
CREATE TABLE session
(
    id       serial PRIMARY KEY,
    hall_id  int NOT NULL,
    movie_id int NOT NULL,
    time     timestamp NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT FK_session_hall FOREIGN KEY (hall_id) REFERENCES hall (id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FK_session_movie FOREIGN KEY (movie_id) REFERENCES movie (id) ON DELETE CASCADE ON UPDATE CASCADE
);

/* Цены на сеансы */
CREATE TABLE session_price
(
    id         serial PRIMARY KEY,
    session_id int NOT NULL,
    place_id   int NOT NULL,
    price      int NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT FK_session_price_session FOREIGN KEY (session_id) REFERENCES session (id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FK_session_price_place FOREIGN KEY (place_id) REFERENCES place (id) ON DELETE CASCADE ON UPDATE CASCADE
);

/* Клиенты */
CREATE TABLE client
(
    id       serial PRIMARY KEY,
    name     varchar(255) NOT NULL,
    surname  varchar(255) NULL,
    lastname varchar(255) NULL,
    email    varchar(255) NOT NULL,
    phone    int NOT NULL,
    PRIMARY KEY (id)
);

/* Билеты */
CREATE TABLE ticket
(
    id               serial PRIMARY KEY,
    session_price_id int NOT NULL,
    client_id        int NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT FK_ticket_session_price FOREIGN KEY (session_price_id) REFERENCES session_price (id) ON DELETE CASCADE ON UPDATE CASCADE
);

