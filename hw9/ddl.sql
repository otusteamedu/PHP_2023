CREATE TABLE movies (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
);

CREATE TABLE attributes (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    data_id INT NOT NULL
);

CREATE INDEX data_id_index ON attributes (data_id);

CREATE TABLE attribute_types (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE attributes_values (
    id SERIAL PRIMARY KEY,
    movie_id INT REFERENCES movies(movie_id),
    attribute_id INT REFERENCES attributes(attribute_id),
    value TEXT
);

CREATE INDEX movie_id_index ON attributes_values (movie_id);
CREATE INDEX attribute_id_index ON attributes_values (attribute_id);