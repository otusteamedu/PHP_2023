create schema cinema collate utf8mb4_unicode_ci;

create table films
(
    id   int auto_increment
        primary key,
    name varchar(100) not null
);

create table halls
(
    id       int auto_increment
        primary key,
    name     varchar(100) not null,
    capacity int          not null
);

create table places
(
    id           int auto_increment
        primary key,
    place_number int not null,
    row          int not null,
    hall_id      int not null,
    constraint places_halls_id_fk
        foreign key (hall_id) references halls (id)
);

create table seances
(
    id      int auto_increment
        primary key,
    hall_id int       not null,
    film_id int       not null,
    start   timestamp null,
    end     timestamp null,
    constraint seances_films_id_fk
        foreign key (film_id) references films (id),
    constraint seances_halls_id_fk
        foreign key (hall_id) references halls (id)
);

create table tickets
(
    id        int auto_increment
        primary key,
    seance_id int not null,
    place_id  int null,
    price     int not null,
    constraint tickets_places_id_fk
        foreign key (place_id) references places (id),
    constraint tickets_seances_id_fk
        foreign key (seance_id) references seances (id)
);

create table users
(
    id    int auto_increment
        primary key,
    name  varchar(100) not null,
    phone varchar(20)  not null,
    email varchar(30)  not null
);

create table orders
(
    id        int auto_increment
        primary key,
    user_id   int not null,
    ticket_id int not null,
    constraint orders_tickets_id_fk
        foreign key (ticket_id) references tickets (id),
    constraint orders_users_id_fk
        foreign key (user_id) references users (id)
);

