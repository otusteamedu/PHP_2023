create table movies
(
    id serial primary key,
    name varchar(128) not null
);

create table types
(
    id serial primary key,
    name varchar(64) not null
);

create table attributes
(
    id serial primary key,
    type_id integer not null,
    name varchar(64) not null,
    foreign key (type_id) references types (id)
);

create table 'values'
(
    id serial primary key,
    movie_id integer not null,
    attribute_id integer not null,
    int_value    integer,
    float_value  double precision,
    bool_value   boolean,
    text_value   text,
    date_value   date,
    foreign key (movie_id) references movies (id),
    foreign key (attribute_id) references attributes (id)
);