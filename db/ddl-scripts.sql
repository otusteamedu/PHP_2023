create table if not exists Halls
(
    id          int auto_increment
        primary key,
    name        varchar(255) null comment 'Наименование',
    description tinytext     null,
    capacity    int          not null comment 'количество мест'
)
    comment 'Кинозалы';

create table if not exists Movies
(
    id          int          auto_increment
        primary key,
    name        varchar(255) not null,
    description text         not null,
    year        int          not null
);

create table if not exists Seats
(
    id      int auto_increment
        primary key,
    number  varchar(255) null comment 'номер места',
    hall_id int          null,
    constraint Seats_ibfk_1
        foreign key (hall_id) references Halls (id)
);

create table if not exists Sessions
(
    id               int auto_increment
        primary key,
    session_datetime datetime not null,
    movie_id         int      not null,
    hall_id          int      not null,
    constraint Sessions_Halls_null_fk
        foreign key (hall_id) references Halls (id),
    constraint Sessions_Movies_null_fk
        foreign key (movie_id) references Movies (id)
);

create table if not exists Tickets
(
    id         int auto_increment
        primary key,
    session_id int not null,
    seat_id    int not null,
    price      int null,
    constraint Tickets_Seats_null_fk
        foreign key (seat_id) references Seats (id),
    constraint Tickets_Sessions_null_fk
        foreign key (session_id) references Sessions (id)
);

create table if not exists Ticket_payments
(
    id               int                   not null,
    payment_datetime datetime              not null,
    payment_type     enum ('cash', 'card') not null,
    ticket_id        int                   not null,
    constraint Ticket_payments_Tickets_null_fk
        foreign key (ticket_id) references Tickets (id)
);