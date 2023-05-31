create table if not exists cinema.film
(
    id   int auto_increment
    primary key,
    name text not null
);

create table if not exists cinema.room
(
    id int auto_increment
    primary key
);

create table if not exists cinema.seat
(
    number  int null,
    room_id int null,
    id      int auto_increment,
    price   int
    primary key
);

create table if not exists cinema.session
(
    id      int auto_increment
    primary key,
    room_id int  not null,
    `from`  time not null,
    `to`    time not null,
    date    date null,
    film    int  null,
    constraint session_film_id_fk
    foreign key (film) references cinema.film (id),
    constraint session_room_id_fk
    foreign key (room_id) references cinema.room (id)
    );

create table if not exists cinema.ticket
(
    id      int auto_increment
    primary key,
    session int   not null,
    seat    int   null,
    constraint ticket_seat_id_fk
    foreign key (seat) references cinema.seat (id),
    constraint ticket_session_id_fk
    foreign key (session) references cinema.session (id)
    );

