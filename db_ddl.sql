create table if not exists public.halls
(
    id    serial
        constraint halls_pk
            primary key,
    title char not null
);


create table if not exists public.tickets
(
    id      serial
        constraint tickets_pk
            primary key,
    date    date                  not null,
    time    time                  not null,
    hall_id integer               not null
        constraint tickets_halls_id_fk
            references public.halls,
    row     integer               not null,
    place   integer               not null,
    sale    boolean default false not null
);



create table if not exists public.movies
(
    id    serial
        constraint movies_pk
            primary key,
    title char(255) not null
);


create table if not exists public.category
(
    id    serial
        constraint category_pk
            primary key,
    title char(255)
);

create table if not exists public.place_and_rows
(
    id          serial
        constraint place_and_rows_pk
            primary key,
    hall_id     integer not null
        constraint place_and_rows_halls_id_fk
            references public.halls,
    place       integer not null,
    row         integer,
    category_id integer not null
        constraint place_and_rows_category_id_fk
            references public.category
);


create table if not exists public.sessions
(
    id       serial
        constraint sessions_pk
            primary key,
    date     date    not null,
    time     time    not null,
    hall_id  integer
        constraint sessions_halls_id_fk
            references public.halls,
    movie_id integer not null
        constraint sessions_movies_id_fk
            references public.movies
);


create table if not exists public.prices
(
    id          serial
        constraint prices_pk
            primary key,
    date        date             not null,
    time        serial,
    category_id integer          not null
        constraint prices_category_id_fk
            references public.category,
    price       double precision not null
);

create table if not exists public.booking
(
    id        serial
        constraint booking_pk
            primary key,
    ticket_id integer          not null
        constraint booking_tickets_id_fk
            references public.tickets,
    amount    double precision not null
);


