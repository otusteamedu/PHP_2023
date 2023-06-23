DROP TABLE IF EXISTS movies;
CREATE TABLE movies (
    id SERIAL PRIMARY KEY, 
    name CHARACTER VARYING(255)
);

DROP TABLE IF EXISTS attribute_types;
CREATE TABLE attribute_types (
    id SERIAL PRIMARY KEY,  
    name CHARACTER VARYING(255)
);

DROP TABLE IF EXISTS attributes;
CREATE TABLE attributes (
    id SERIAL PRIMARY KEY,  
    name CHARACTER VARYING(255),
    attribute_type_id INTEGER,
    FOREIGN KEY (attribute_type_id) REFERENCES attribute_types (id)
);

-- value - name reserved -> use values_

DROP TABLE IF EXISTS values_;
CREATE TABLE values_ (
    movie_id INTEGER, 
    attribute_id INTEGER,
    v_int INTEGER,
    v_dec DECIMAL(10, 2),
    v_text TEXT,
    v_date DATE,
    v_bool BOOLEAN,
    FOREIGN KEY (movie_id) REFERENCES movies (id),
    FOREIGN KEY (attribute_id) REFERENCES attributes (id)
);