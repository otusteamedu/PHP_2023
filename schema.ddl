CREATE DATABASE cinema;

CREATE TABLE films
(
    id          serial PRIMARY KEY,
    title       varchar(255),
    description text
);

CREATE TABLE attributes
(
    id   serial PRIMARY KEY,
    name varchar(255)
);

CREATE TABLE attribute_types
(
    id   serial PRIMARY KEY,
    name varchar(255)
);

CREATE TABLE values
(
    value_id      serial PRIMARY KEY,
    film_id       INT REFERENCES films (id),
    attribute_id  INT REFERENCES attributes (id),
    type_id       INT REFERENCES attribute_types (id),
    text_value    text,
    bool_value    boolean,
    date_value    date,
    integer_value integer
);
