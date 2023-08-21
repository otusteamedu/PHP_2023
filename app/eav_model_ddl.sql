CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

create table movie
(
    id       uuid DEFAULT uuid_generate_v4() NOT NULL PRIMARY KEY,
    name     varchar(100)                    NOT NULL,
    duration interval HOUR TO SECOND         NOT NULL
);

create table movie_attribute
(
    id   uuid DEFAULT uuid_generate_v4() NOT NULL PRIMARY KEY,
    name varchar(100)                    NOT NULL,
    type varchar(20)                     NOT NULL
);
drop table movie_attribute_value;
create table movie_attribute_value
(
    id            uuid DEFAULT uuid_generate_v4() NOT NULL PRIMARY KEY,
    movie_id      uuid REFERENCES movie (id),
    attribute_id  uuid REFERENCES movie_attribute (id),
    value_text    text,
    value_string  varchar(255),
    value_integer integer,
    value_boolean boolean,
    value_decimal decimal,
    value_date    date
);