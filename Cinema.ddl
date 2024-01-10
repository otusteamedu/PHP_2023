create table films
(
    id serial primary key,
    name varchar(128) not null
);

create table type
(
    id serial primary key,
    name varchar(64) not null
);

create table attributes
(
    id serial primary key,
    type_id integer not null,
    name varchar(64) not null,
    foreign key (type_id) references type (id)
);

create table value
(
    id serial primary key,
    film_id integer not null,
    attribute_id integer not null,
    int_value    integer,
    float_value  double precision,
    bool_value   boolean,
    text_value   text,
    date_value   date,
    foreign key (film_id) references films (id),
    foreign key (attribute_id) references attributes (id)
);