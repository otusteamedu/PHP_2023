create table Halls
(
    id          int auto_increment
        primary key,
    name        varchar(255) null comment 'Наименование',
    description tinytext     null,
    capacity    int          not null comment 'количество мест'
)
    comment 'Кинозалы';


create table Movies
(
    id          int          not null
        primary key,
    name        varchar(255) not null,
    description text         not null,
    year        int          not null,
    movie_type  int          not null
);


create table Seats
(
    id        int auto_increment
        primary key,
    number    varchar(255) null comment 'номер места',
    hall_id   int          null,
    seat_type int          null
);


create table Sessions
(
    id               int auto_increment
        primary key,
    session_datetime datetime not null,
    movie_id         int      not null,
    hall_id          int      not null,
    time_type_id     int      not null,
    constraint Sessions_Halls_null_fk
        foreign key (hall_id) references Halls (id),
    constraint Sessions_Movies_null_fk
        foreign key (movie_id) references Movies (id)
);


create table Movie_types
(
    id   int auto_increment
        primary key,
    name varchar(255) null
)
    comment 'Типы фильмов по ожидаемой прибыльности: блокбастеры, фестивальное кино и тд';


create table Seat_types
(
    id   int auto_increment
        primary key,
    name varchar(255) not null
)
    comment 'Типы мест: обычные, VIP, LS и тд';


create table Time_types
(
    id   int auto_increment
        primary key,
    name varchar(255) not null
)
    comment 'Типы времени: утро, день, праймтайм и тд ';


create table Prices
(
    id            int auto_increment
        primary key,
    movie_type_id int not null,
    time_type_id  int not null,
    seat_type_id  int not null,
    price         int not null,
    constraint Prices_Movie_types_null_null_fk
        foreign key (movie_type_id) references Movie_types (id),
    constraint Prices_Seat_types_null_fk
        foreign key (seat_type_id) references Seat_types (id),
    constraint Prices_Time_types_null_fk
        foreign key (time_type_id) references Time_types (id)
)
    comment 'Справочник цен';


create table Tickets
(
    id         int auto_increment
        primary key,
    session_id int not null,
    price_id   int not null,
    constraint Tickets_Seats_null_fk
        foreign key (price_id) references Seats (id),
    constraint Tickets_Sessions_null_fk
        foreign key (session_id) references Sessions (id)
);