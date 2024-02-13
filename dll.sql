create table cinema
(
    id          serial
        constraint cinema_pk
            primary key,
    name        varchar(255) not null,
    description text         not null
);

create table cinema_hall
(
    id          serial
        constraint cinema_pk
            primary key,
    cinema_id int,
    FOREIGN KEY (cinema_id) REFERENCES cinema(id),
    name        varchar(255) not null,
    seats int         not null
);

create table film
(
    id          serial
        constraint cinema_pk
            primary key,
    name        varchar(255) not null,
    started_at timestamp not null,
);

create table cinema_sessions
(
    id          serial
        constraint cinema_pk
            primary key,
    cinema_hall_id int,
    FOREIGN KEY (cinema_hall_id) REFERENCES cinema_hall(id),
    film_id int,
    FOREIGN KEY (film_id) REFERENCES film(id),
    name        varchar(255) not null,
    started_at timestamp not null,
    end_at timestamp not null,
);

create table ticket
(
    id          serial
        constraint cinema_pk
            primary key,
    cinema_sessions_id int,
    FOREIGN KEY (cinema_sessions_id) REFERENCES cinema_sessions(id),
    name        varchar(255) not null,
    created_at timestamp not null,
    price int not null,
);