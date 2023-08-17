CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

create table halls
(
    id          uuid DEFAULT uuid_generate_v4() NOT NULL PRIMARY KEY,
    number      int                             NOT NULL
        check ( number > 0 ),
    seats_count int                             NOT NULL
        check ( seats_count > 0 )
);

create table movies
(
    id       uuid DEFAULT uuid_generate_v4() NOT NULL PRIMARY KEY,
    name     varchar(100)                    NOT NULL,
    duration interval HOUR TO SECOND         NOT NULL
);

create table sessions
(
    id       uuid DEFAULT uuid_generate_v4() NOT NULL PRIMARY KEY,
    movie_id uuid REFERENCES movies (id),
    hall_id  uuid REFERENCES halls (id),
    begin_at timestamp                       NOT NULL
);

create table orders
(
    id         uuid DEFAULT uuid_generate_v4() NOT NULL PRIMARY KEY,
    session_id uuid REFERENCES sessions (id),
    row        int                             NOT NULL check (row > 0),
    seat       int                             NOT NULL check (seat > 0),
    price      int                             NOT NULL check (price >= 0)
);


drop table if exists orders;
drop table if exists sessions;
drop table if exists movies;
drop table if exists halls;