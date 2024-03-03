CREATE TABLE IF NOT EXISTS films
(
    id       serial PRIMARY KEY,
    name     varchar(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS attribute_types
(
    id   serial PRIMARY KEY,
    name varchar(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS attributes
(
    id      serial PRIMARY KEY,
    name    varchar(100) NOT NULL,
    type_id integer      NOT NULL
);

ALTER TABLE attributes
    ADD CONSTRAINT attributes_types_id_fk
        FOREIGN KEY (type_id) REFERENCES attribute_types (id);

CREATE TABLE IF NOT EXISTS attribute_values
(
    films_id     INTEGER NOT NULL,
    attribute_id INTEGER NOT NULL,
    varchar      VARCHAR(255),
    bool         BOOLEAN,
    integer      INTEGER,
    float        FLOAT,
    money        MONEY,
    date         DATE
);

ALTER TABLE attribute_values
    ADD CONSTRAINT attribute_values_films_id_fk
        FOREIGN KEY (films_id) REFERENCES films (id)
            ON UPDATE CASCADE
            ON DELETE CASCADE;

ALTER TABLE attribute_values
    ADD CONSTRAINT attribute_values_attribute_id_fk
        FOREIGN KEY (attribute_id) REFERENCES attributes (id)
            ON UPDATE CASCADE
            ON DELETE CASCADE;

CREATE INDEX idx_films_name ON films(name);
CREATE INDEX idx_attribute_values_films_id ON attribute_values(films_id);



