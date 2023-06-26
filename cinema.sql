CREATE TABLE movies (
    id SERIAL PRIMARY KEY, 
    name CHARACTER VARYING(255)
);

CREATE TABLE attribute_types (
    id SERIAL PRIMARY KEY,  
    name CHARACTER VARYING(255)
);

CREATE TABLE attributes (
    id SERIAL PRIMARY KEY,  
    name CHARACTER VARYING(255),
    attribute_type_id INTEGER,
    FOREIGN KEY (attribute_type_id) REFERENCES attribute_types (id)
);


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


CREATE INDEX entity_idx ON values_ USING btree (movie_id, attribute_id);

CREATE INDEX value_date_idx ON values_ USING btree (v_date);