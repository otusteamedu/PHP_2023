create database cinema;
create schema public;

create table if not exists public.hall
(
    id            serial
        constraint hall_pk
            primary key,
    name          varchar(64) not null,
    class         varchar(32) not null,
    total_columns integer     not null,
    total_rows    integer     not null
);

create table film
(
    id   serial
        constraint film_pk
            primary key,
    name varchar(64) not null
);

create table client
(
    id       serial
        constraint client_pk
            primary key,
    name     varchar(64) not null,
    age      integer     not null,
    discount integer
);

create table session
(
    id      serial
        constraint session_pk
            primary key,
    hall_id integer not null
        constraint session_hall_id_fk
            references hall,
    film_id integer not null
        constraint session_film_id_fk
            references film,
    date    date    not null,
    price   integer not null
);

create table public.ticket
(
    session_id integer not null
        constraint ticket_session_id_fk
            references public.session,
    client_id  integer not null
        constraint ticket_client_id_fk
            references public.client,
    cost       integer not null,
    row        integer not null,
    "column"   integer not null
);