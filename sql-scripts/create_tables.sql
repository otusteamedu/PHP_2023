CREATE TABLE "movie" (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

CREATE TABLE "attribute_type" (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    type VARCHAR(50) NOT NULL
);

CREATE TABLE "attribute" (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    type_id integer REFERENCES attribute_type(id)
);

CREATE TABLE "movie_data" (
    id BIGSERIAL PRIMARY KEY,
    movie_id integer REFERENCES movie(id),
    attribute_id integer REFERENCES attribute(id),
    value_text text default null,
    value_boolean bool default null,
    value_float numeric default null,
    value_integer numeric default null,
    value_date timestamp without time zone default null
);

CREATE INDEX IDX_movie_data_attribute ON movie_data (attribute_id);