create table room
(
    id serial not null
        constraint room_pkey
            primary key,
    name varchar(50) default ''::character varying not null
);

comment on table room is 'кинозал';

comment on column room.name is 'имя зала';

alter table room owner to postgres;

create table seat_class
(
    id serial not null
        constraint seat_class_pkey
            primary key,
    name varchar(50) default ''::character varying not null
);

comment on table seat_class is 'класс мест';

comment on column seat_class.name is 'имя класса';

alter table seat_class owner to postgres;

create table movie
(
    id serial not null
        constraint movie_pkey
            primary key,
    name varchar(50) default ''::character varying not null
);

comment on table movie is 'фильмы';

comment on column movie.name is 'название фильма';

alter table movie owner to postgres;

create table seat
(
    id serial not null
        constraint seat_pkey
            primary key,
    room_id integer not null
        constraint fk__room
            references room
            on update restrict on delete restrict,
    seat_class integer not null
        constraint fk__seat_class
            references seat_class
            on update restrict on delete restrict,
    row integer not null,
    num integer not null
);

comment on table seat is 'места в залах';

comment on column seat.room_id is 'id зала';

comment on column seat.seat_class is 'класс места';

comment on column seat.row is 'ряд';

comment on column seat.num is 'место';

alter table seat owner to postgres;

create unique index room_id_s
    on seat (room_id, row, num);

create table schedule
(
    id serial not null
        constraint schedule_pkey
            primary key,
    room_id integer
        constraint fk__room_s
            references room,
    movie_id integer
        constraint fk__movie_s
            references movie,
    datetime timestamp
);

comment on table schedule is 'расписание сеансов';

comment on column schedule.room_id is 'id зала';

comment on column schedule.movie_id is 'id фильма';

comment on column schedule.datetime is 'время сеанса';

alter table schedule owner to postgres;

create unique index room_id_schedule
    on schedule (room_id, datetime);

create table seat_price
(
    id serial not null
        constraint seat_price_pkey
            primary key,
    seat_class_id integer not null
        constraint fk__seat_class_sp
            references seat_class,
    schedule_id integer not null
        constraint fk__schedule_sp
            references schedule,
    price numeric(8,2) default 0 not null
);

comment on table seat_price is 'цена мест';

comment on column seat_price.seat_class_id is 'класс места';

comment on column seat_price.schedule_id is 'сеанс';

comment on column seat_price.price is 'цена';

alter table seat_price owner to postgres;

create unique index seat_class_id_sp
    on seat_price (seat_class_id, schedule_id);

create table sold_ticket
(
    id serial not null
        constraint sold_ticket_pkey
            primary key,
    schedule_id integer
        constraint fk__schedule_st
            references schedule,
    seat_id integer
        constraint fk__seat_st
            references seat
);

comment on table sold_ticket is 'проданные билеты';

comment on column sold_ticket.schedule_id is 'сеанс';

comment on column sold_ticket.seat_id is 'место';

alter table sold_ticket owner to postgres;

create unique index schedule_id_st
    on sold_ticket (schedule_id, seat_id);

create table movie_attribute_value
(
    attr_id serial not null
        constraint movie_attribute_value_pk
            primary key,
    value_text varchar(1000),
    value_date timestamp,
    value_bool boolean
);

comment on table movie_attribute_value is 'значения атрибутов фильма';

comment on column movie_attribute_value.attr_id is 'id атрибута';

comment on column movie_attribute_value.value_text is 'текст';

comment on column movie_attribute_value.value_date is 'дата';

comment on column movie_attribute_value.value_bool is 'логическое значение';

alter table movie_attribute_value owner to postgres;

create table movie_attribute_types
(
    id serial not null
        constraint movie_attribute_types_pk
            primary key,
    name varchar(20)
);

comment on table movie_attribute_types is 'типы данных атрибутов фильмов';

comment on column movie_attribute_types.id is 'id типа данных';

comment on column movie_attribute_types.name is 'имя типа данных';

alter table movie_attribute_types owner to postgres;

create table movie_attribute
(
    movie_id integer not null
        constraint movie_attribute_movie_id_fk
            references movie
            on update cascade on delete restrict,
    attr_id integer not null
        constraint movie_attribute_movie_attribute_value_attr_id_fk
            references movie_attribute_value
            on update cascade on delete restrict,
    attr_name varchar(100) not null,
    attr_type integer not null
        constraint movie_attribute_movie_attribute_types_id_fk
            references movie_attribute_types
            on update cascade on delete restrict
);

comment on table movie_attribute is 'аттрибуты фильма';

comment on column movie_attribute.movie_id is 'id фильма';

comment on column movie_attribute.attr_id is 'id атрибута';

comment on column movie_attribute.attr_name is 'Наименование атрибута';

comment on column movie_attribute.attr_type is 'id типа данных атрибута';

alter table movie_attribute owner to postgres;

create index movie_attribute_movie_id_index
    on movie_attribute (movie_id);