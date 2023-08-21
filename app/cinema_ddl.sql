
drop table if exists halls cascade;
create table halls
(
    id            serial primary key,
    name          varchar(30) unique not null,
    rows_count    smallint           not null
        check ( rows_count > 0),
    seats_per_row smallint           not null
        check ( seats_per_row > 0 )

);

drop table if exists hall_schema cascade;
create table hall_schema
(
    id      serial primary key,
    hall_id integer references halls (id),
    row     smallint                        not null,
    seat    smallint                        not null
);
alter table hall_schema
    add constraint hall_schema_uniq_idx unique (hall_id, row, seat);

drop table if exists movies cascade;
create table movies
(
    id       serial primary key,
    name     varchar(100)                    not null,
    duration interval hour to second         not null
);

drop table if exists sessions cascade;
create table sessions
(
    id       serial primary key,
    movie_id integer,
    hall_id  integer,
    begin_at timestamp                       not null
);

drop table if exists tickets cascade;
create table tickets
(
    id             serial primary key,
    session_id     integer,
    hall_schema_id integer,
    price          int                             not null,
    created_at     timestamp                       not null
);

alter table tickets
    add constraint ticket_session_fk foreign key (session_id) references sessions (id);
alter table tickets
    add constraint ticket_hall_schema_fk foreign key (hall_schema_id) references hall_schema (id);
alter table tickets
    add constraint ticket_check_price_idx check ( price >= 0 );


alter table sessions
    add constraint session_movie_fk foreign key (movie_id) references movies (id);
alter table sessions
    add constraint session_hall_fk foreign key (hall_id) references halls (id);