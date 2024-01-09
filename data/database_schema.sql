CREATE TABLE IF NOT EXISTS film (
    id          bigint PRIMARY KEY,
    name        varchar(255) NOT NULL,
    description varchar(255)
);

CREATE TABLE IF NOT EXISTS hall (
    id          bigint PRIMARY KEY,
    name        varchar(255) NOT NULL,
    description varchar(255)
);

CREATE TABLE IF NOT EXISTS place (
    id      bigint PRIMARY KEY,
    row     smallint      NOT NULL,
    number  smallint      NOT NULL,
    hall_id bigint        NOT NULL,
    markup  numeric(5, 2) NOT NULL,
    FOREIGN KEY (hall_id) REFERENCES hall(id)
);

CREATE TABLE IF NOT EXISTS client (
    id         bigint PRIMARY KEY,
    surname    varchar(150)       NOT NULL,
    name       varchar(150)       NOT NULL,
    patronymic varchar(150)       NOT NULL,
    email      varchar(70) UNIQUE NOT NULL,
    phone      varchar(11) UNIQUE NOT NULL,
    created_at timestamptz        NOT NULL
);

CREATE TABLE IF NOT EXISTS seance (
    id      bigint PRIMARY KEY,
    film_id bigint      NOT NULL,
    hall_id bigint      NOT NULL,
    date    timestamptz NOT NULL,
    FOREIGN KEY (film_id) REFERENCES film(id),
    FOREIGN KEY (hall_id) REFERENCES hall(id)
);

CREATE TABLE IF NOT EXISTS price (
    id        bigint PRIMARY KEY,
    seance_id bigint NOT NULL,
    place_id  bigint NOT NULL,
    price     numeric(7, 2),
    FOREIGN KEY (seance_id) REFERENCES seance(id),
    FOREIGN KEY (place_id) REFERENCES place(id)
);

CREATE TABLE IF NOT EXISTS ticket (
    id        bigint PRIMARY KEY,
    date      timestamptz NOT NULL,
    client_id bigint      NOT NULL,
    price     bigint      NOT NULL,
    FOREIGN KEY (client_id) REFERENCES client(id),
    FOREIGN KEY (price) REFERENCES price(id)
);
