CREATE TABLE movie
(
    id SERIAL PRIMARY KEY,
    name CHARACTER VARYING(255) NOT NULL,
    director CHARACTER VARYING(255) NOT NULL,
    genre CHARACTER VARYING(255) NOT NULL,
    duration SMALLINT NOT NULL
);

CREATE TABLE attribute_type
(
    id SERIAL PRIMARY KEY,
    name CHARACTER VARYING(255) NOT NULL
);

CREATE TABLE attribute
(
    id SERIAL PRIMARY KEY,
    name CHARACTER VARYING(255) NOT NULL,
    type_id INT NOT NULL,
    FOREIGN KEY (type_id) REFERENCES attribute_type (id)
);

CREATE TABLE value
(
    id SERIAL PRIMARY KEY,
    movie_id INT NOT NULL,
    attribute_id INT NOT NULL,
    text_value TEXT,
    boolean_value BOOLEAN,
    date_value DATE,
    FOREIGN KEY (movie_id) REFERENCES movie (id),
    FOREIGN KEY (attribute_id) REFERENCES attribute (id)
);
