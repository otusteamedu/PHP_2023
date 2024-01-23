DROP TABLE IF EXISTS hall;
CREATE TABLE hall (
    id           serial PRIMARY KEY,
    name         varchar(100) NOT NULL,
    places_count smallint     not null
);

INSERT INTO hall (id, name, places_count) VALUES (1, 'Зал 1', 100);
INSERT INTO hall (id, name, places_count) VALUES (2, 'Зал 2', 100);
INSERT INTO hall (id, name, places_count) VALUES (3, 'Зал 3', 75);
INSERT INTO hall (id, name, places_count) VALUES (4, 'VIP зал', 20);

DROP TABLE IF EXISTS movie;
CREATE TABLE movie (
    id           serial PRIMARY KEY,
    title        varchar(255) NOT NULL,
    description  text NOT NULL,
    premier_date DATE         NULL,
    duration     integer      NOT NULL
);

DROP TABLE IF EXISTS client;
CREATE TABLE client (
    id    serial PRIMARY KEY,
    name  varchar(100) NOT NULL,
    phone varchar(20)  NOT NULL UNIQUE
);

DROP TABLE IF EXISTS place_type;
CREATE TABLE place_type (
    id   serial PRIMARY KEY,
    name varchar(60) NOT NULL
);

INSERT INTO place_type (id, name) VALUES (1, 'standard');
INSERT INTO place_type (id, name) VALUES (2, 'vip');
INSERT INTO place_type (id, name) VALUES (3, 'kiss');

DROP TABLE IF EXISTS place;
CREATE TABLE place (
    id            serial PRIMARY KEY,
    row           smallint NOT NULL,
    number        smallint NOT NULL,
    hall_id       integer  NOT NULL,
    place_type_id integer  NOT NULL,
    FOREIGN KEY (hall_id) REFERENCES hall(id) ON DELETE CASCADE,
    FOREIGN KEY (place_type_id) REFERENCES place_type(id) ON DELETE CASCADE
);

DROP TABLE IF EXISTS price;
CREATE TABLE price (
    id    serial PRIMARY KEY,
    price integer NOT NULL,
    session_id integer NOT NULL,
    place_id integer NOT NULL
);

DROP TABLE IF EXISTS session;
CREATE TABLE session (
    id       serial PRIMARY KEY,
    hall_id  integer NOT NULL,
    movie_id integer NOT NULL,
    date     DATE    NOT NULL,
    time     time    NOT NULL,
    FOREIGN KEY (hall_id) REFERENCES hall(id) ON DELETE CASCADE,
    FOREIGN KEY (movie_id) REFERENCES movie(id) ON DELETE CASCADE
);

DROP TABLE IF EXISTS ticket;
CREATE TABLE ticket (
    id         serial PRIMARY KEY,
    client_id  integer   NOT NULL,
    session_id integer   NOT NULL,
    created_at timestamp NOT NULL,
    place_id   integer   NOT NULL,
    FOREIGN KEY (session_id) REFERENCES session(id) ON DELETE CASCADE,
    FOREIGN KEY (client_id) REFERENCES client(id) ON DELETE CASCADE,
    FOREIGN KEY (place_id) REFERENCES place(id) ON DELETE CASCADE
);
