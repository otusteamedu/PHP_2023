CREATE TABLE movies
(
    id    SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL
);

CREATE TABLE attributes
(
    id                SERIAL PRIMARY KEY,
    attribute_type_id INTEGER      NOT NULL REFERENCES attribute_types (id),
    attribute         VARCHAR(255) NOT NULL
);

CREATE TABLE attribute_types
(
    id             SERIAL PRIMARY KEY,
    attribute_type VARCHAR(255) NOT NULL
);

CREATE TABLE values
(
    id            SERIAL PRIMARY KEY,
    movie_id      INTEGER NOT NULL REFERENCES movies (id),
    attribute_id  INTEGER NOT NULL REFERENCES attributes (id),
    text_value    TEXT,
    boolean_value BOOLEAN,
    date_value    DATE,
    float_value   FLOAT,
    int_value     INT
);
