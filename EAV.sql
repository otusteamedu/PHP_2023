CREATE TABLE IF NOT EXISTS attributes_type
(
    id   SERIAL PRIMARY KEY,
    name text NOT NULL
);

CREATE TABLE IF NOT EXISTS attributes
(
    id                SERIAL PRIMARY KEY,
    name              text NOT NULL,
    attribute_type_id SERIAL REFERENCES attributes_type (id)
    );

CREATE TABLE IF NOT EXISTS attributes_values
(
    id            SERIAL PRIMARY KEY,
    movie_id     SERIAL REFERENCES movies (id),
    attribute_id  SERIAL REFERENCES attributes (id),
    val_text      text,
    val_date      date,
    val_timestamp timestamp,
    val_num       real,
    val_bool      boolean,
    val_int       integer,
    val_float     float
    );