create table holl_types
(
    id   serial primary key,
    name varchar(100) unique not null
);

create table holls
(
    id           serial primary key,
    holl_type_id int                 not null,
    name         varchar(256) unique not null,
    constraint fk_holl_type_id_holl_types foreign key (holl_type_id) references holl_types (id)
);

create table movies
(
    id         serial primary key,
    tittle     varchar(256) not null,
    durantion  int          not null,
    director   varchar(256) not null,
    date_start date         not null
);

create table users
(
    id    serial primary key,
    mail  varchar(256) not null,
    phone int          not null
);

create table seats
(
    id      serial primary key,
    holl_id int not null,
    row     int not null,
    seat    int not null,
    constraint fk_holl_id_seats foreign key (holl_id) references holls (id)
);

create table sessions
(
    id          serial primary key,
    movie_id    int     not null,
    holl_id     int     not null,
    time        int     not null,
    ticket_cost numeric not null default 0,
    constraint fk_holl_id_sessions foreign key (holl_id) references holls (id),
    constraint fk_movie_id_sessions foreign key (movie_id) references movies (id)
);

create table reservations
(
    id         serial primary key,
    session_id int     not null,
    user_id    int     not null,
    paid       bool             default false,
    cost       numeric not null default 0,
    constraint fk_session_id_reservations foreign key (session_id) references sessions (id),
    constraint fk_user_id_reservations foreign key (user_id) references users (id)
);

create table seat_reservations
(
    id             serial primary key,
    seat_id        int not null,
    reservation_id int not null,
    constraint fk_seat_id_seat_reservations foreign key (seat_id) references seats (id),
    constraint fk_reservation_id_seat_reservations foreign key (reservation_id) references reservations (id)
);
