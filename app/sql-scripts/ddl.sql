CREATE TABLE halls
(
    id           serial       not null
        constraint halls_pkey
            primary key,
    name         varchar(255) not null,
    description text         null
);

CREATE TABLE movies
(
    id       serial       not null
        constraint movies_pkey
            primary key,
    title    varchar(255) not null,
    genre    varchar(50)  not null,
    duration integer      not null
);

CREATE TABLE users
(
    id      serial       not null
        constraint users_pkey
            primary key,
    phone   varchar(255) not null,
    name    varchar(255) not null,
    surname varchar(255) not null
);

CREATE TABLE sessions
(
    id         serial    not null
        constraint sessions_pkey
            primary key,
    hall_id    integer
        constraint sessions_hall_id_fkey
            references halls,
    movie_id   integer
        constraint sessions_movie_id_fkey
            references movies,
    start_time timestamp not null
);

CREATE TABLE seats_types
(
    id    serial       not null
        constraint seats_types_pkey
            primary key,
    title varchar(255) not null
);

CREATE TABLE seats
(
    id             serial  not null
        constraint seats_pkey
            primary key,
    row            integer not null,
    place          integer not null,
    seats_types_id integer
        constraint seats_seats_types_id_fkey
            references seats_types,
    halls_id       integer
        constraint seats_halls_id_fkey
            references halls
);

CREATE TABLE prices
(
    id             serial         not null
        constraint prices_pkey
            primary key,
    price          numeric(10, 2) not null,
    seats_types_id integer
        constraint prices_seats_types_id_fkey
            references seats_types,
    sessions_id    integer
        constraint prices_sessions_id_fkey
            references sessions
);

CREATE TABLE tickets
(
    id          serial not null
        constraint tickets_pkey
            primary key,
    sessions_id integer
        constraint tickets_sessions_id_fkey
            references sessions,
    prices_id   integer
        constraint tickets_prices_id_fkey
            references prices,
    price       numeric(10, 2) not null,
    seats_id    integer
        constraint tickets_seats_id_fkey
            references seats
);

CREATE TABLE orders
(
    id        serial not null
        constraint orders_pkey
            primary key,
    ticket_id integer
        constraint orders_ticket_id_fkey
            references tickets,
    user_id   integer
        constraint orders_user_id_fkey
            references users
);

CREATE TABLE attributes_types
(
    id   serial       not null
        constraint attributes_types_pkey
            primary key,
    name varchar(255) not null
);

CREATE TABLE attributes_names
(
    id                  serial not null
        constraint attributes_names_pkey
            primary key,
    name                varchar(255),
    attributes_types_id integer
        constraint attributes_names_attributes_types_id_fkey
            references attributes_types
);

CREATE INDEX ON attributes_names (attributes_types_id);

CREATE TABLE attributes_values
(
    id                  serial not null
        constraint attributes_values_pkey
            primary key,
    movies_id           integer
        constraint attributes_values_movies_id_fkey
            references movies,
    attributes_names_id integer
        constraint attributes_values_attributes_names_id_fkey
            references attributes_names,
    value_text          text,
    value_int           integer,
    value_bool          boolean,
    value_date          date,
    value_numeric       numeric(10, 2)
);

CREATE INDEX ON attributes_values (movies_id);
CREATE INDEX ON attributes_values (attributes_names_id);