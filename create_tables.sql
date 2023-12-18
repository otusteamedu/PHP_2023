CREATE TABLE movies
(
    movie_id SERIAL PRIMARY KEY,
    title    VARCHAR(50)
);

CREATE TABLE types_attributes
(
    type_id   SERIAL PRIMARY KEY,
    type_name VARCHAR(50)
);

CREATE TABLE names_attributes
(
    attr_id      SERIAL PRIMARY KEY,
    attr_type_id INT,
    attr_name    VARCHAR(50),
    FOREIGN KEY (attr_type_id) REFERENCES types_attributes (type_id)
);

CREATE TABLE values_attributes
(
    v_movie_id INT,
    v_attr_id  INT,
    value      VARCHAR(50),
    FOREIGN KEY (v_movie_id) REFERENCES movies (movie_id),
    FOREIGN KEY (v_attr_id) REFERENCES names_attributes (attr_id)
);