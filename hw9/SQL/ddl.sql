CREATE TABLE movies
(
    id   SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE movies_attributes_types
(
    id   SERIAL PRIMARY KEY,
    type VARCHAR(255) NOT NULL
);

CREATE TABLE movies_attributes
(
    id   SERIAL PRIMARY KEY,
    movies_attributes_type_id INTEGER NOT NULL,
    name VARCHAR(50) NOT NULL,
    FOREIGN KEY (movies_attributes_type_id) REFERENCES movies_attributes_types (id)
);


CREATE TABLE movies_attributes_values
(
    id                   SERIAL PRIMARY KEY,
    movie_id             INTEGER NOT NULL,
    movies_attributes_id INTEGER NOT NULL,
    value_string         VARCHAR(5000),
    value_int            INTEGER,
    value_timestamp      TIMESTAMP,
    value_boolean        BOOLEAN,
    value_float          FLOAT,

    FOREIGN KEY (movie_id) REFERENCES movies (id),
    FOREIGN KEY (movies_attributes_id) REFERENCES movies_attributes (id)
);
