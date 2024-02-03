create table halls
(
    id       serial       not null
        constraint halls_pkey
            primary key,
    name     varchar(255) not null,
    capacity integer      not null
);

create table movies
(
    id       serial       not null
        constraint movies_pkey
            primary key,
    title    varchar(255) not null,
    genre    varchar(50)  not null,
    duration integer      not null
);

create table users
(
    id      serial       not null
        constraint users_pkey
            primary key,
    phone   integer      not null,
    name    varchar(255) not null,
    surname varchar(255) not null
);

create table sessions
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

create table tickets
(
    id          serial         not null
        constraint tickets_pkey
            primary key,
    sessions_id integer
        constraint tickets_sessions_id_fkey
            references sessions,
    seat_row    integer        not null,
    seat_place  integer        not null,
    price       numeric(10, 2) not null
);

create table orders
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
