DROP TABLE IF EXISTS attributes_values;
DROP TABLE IF EXISTS attributes_names;
DROP TABLE IF EXISTS movies;
DROP TABLE IF EXISTS attributes_type;

CREATE TABLE movies
(
    movie_id SERIAL PRIMARY KEY,
    movie_name    VARCHAR(50)
);

CREATE TABLE attributes_type
(
    attr_type_id   SERIAL PRIMARY KEY,
    attr_type_name VARCHAR(50)
);

CREATE TABLE attributes_names
(
    attr_name_id      SERIAL PRIMARY KEY,
    attr_type_id INT,
    attr_name    VARCHAR(50),
    FOREIGN KEY (attr_type_id) REFERENCES attributes_type (attr_type_id)
);

CREATE TABLE attributes_values
(
    attr_val_movie_id  INT,
    attr_type_id   INT,
    attr_value_str  TEXT,
    attr_value_int   INT,
    attr_value_bool  BOOLEAN,
    attr_value_date  DATE,
    attr_value_float FLOAT,
    FOREIGN KEY (attr_val_movie_id) REFERENCES movies (movie_id),
    FOREIGN KEY (attr_type_id) REFERENCES attributes_names (attr_name_id)
);

-- Создание индексов

CREATE INDEX idx_attr_val_movie_id ON attributes_values(attr_val_movie_id);
CREATE INDEX idx_attr_type_id ON attributes_values(attr_type_id);
