DROP TABLE IF EXISTS tbl_movies;
CREATE TABLE tbl_movies (
    id SERIAL PRIMARY KEY, 
    name CHARACTER VARYING(255)
);

DROP TABLE IF EXISTS tbl_attribute_types;
CREATE TABLE tbl_attribute_types (
    id SERIAL PRIMARY KEY,  
    name CHARACTER VARYING(255)
);

DROP TABLE IF EXISTS tbl_attributes;
CREATE TABLE tbl_attributes (
    id SERIAL PRIMARY KEY,  
    name CHARACTER VARYING(255),
    attribute_type_id INTEGER,
    FOREIGN KEY (attribute_type_id) REFERENCES tbl_attribute_types (id)
);

DROP TABLE IF EXISTS tbl_values;
CREATE TABLE tbl_values (
    movie_id INTEGER, 
    attribute_id INTEGER,
    v_int INTEGER,
    v_dec DECIMAL(10, 2),
    v_text TEXT,
    v_date DATE,
    v_bool BOOLEAN,
    FOREIGN KEY (movie_id) REFERENCES tbl_movies (id),
    FOREIGN KEY (attribute_id) REFERENCES tbl_attributes (id)
);