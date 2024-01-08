CREATE TABLE movie (
    id   SERIAL PRIMARY KEY,
    name VARCHAR(1000) NOT NULL
);

CREATE TABLE attribute (
    id             SERIAL PRIMARY KEY,
    name           VARCHAR(255),
    description    VARCHAR(255),
    attribute_type SERIAL NOT NULL
);

CREATE TABLE attribute_type (
    id   SERIAL PRIMARY KEY,
    name VARCHAR(255)
);

CREATE TABLE value (
    id            SERIAL PRIMARY KEY,
    movie_id      SERIAL NOT NULL,
    attribute_id  SERIAL NOT NULL,
    value_text    TEXT,
    value_boolean BOOLEAN,
    value_integer INTEGER,
    value_float   NUMERIC,
    value_date    DATE
);

ALTER TABLE attribute
    ADD CONSTRAINT attribute_attribute_type_fk FOREIGN KEY (attribute_type) REFERENCES attribute_type(id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE value
    ADD CONSTRAINT value_movie_id_fk FOREIGN KEY (movie_id) REFERENCES movie(id) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT value_attribute_id_fk FOREIGN KEY (attribute_id) REFERENCES attribute(id) ON DELETE CASCADE ON UPDATE CASCADE;

CREATE INDEX attribute_name_index
    ON attribute(name);

CREATE INDEX attribute_type_name_index
    ON attribute_type(name);


