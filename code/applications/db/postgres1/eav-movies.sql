CREATE TABLE movies
(
    id serial,
    name varchar(255),
    PRIMARY KEY(id)
);

#табличка типов атрибутов фильма (резензия, премия)
CREATE TABLE "moviesAttributesTypes"
(
    id serial,
    type varchar(255),
    PRIMARY KEY(id)
);

#табличка атрибутов
CREATE TABLE "moviesAttributes"
(
    id serial,
    type_id int not null REFERENCES "moviesAttributesTypes" (id) ON DELETE CASCADE,
    name varchar(255) not null,
    PRIMARY KEY(id)
);

#значения атрибутов кинофильмов
CREATE TABLE "moviesAttributesValues"
(
    id serial,
    movie_id int not null REFERENCES movies (id) ON DELETE CASCADE,
    movies_attr_id int not null REFERENCES "moviesAttributes" (id) on DELETE CASCADE,
    v_text text,
    v_int int,
    v_timestamp timestamp,
    v_bool boolean,
    v_float float,
    PRIMARY KEY(id)
);


