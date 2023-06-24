CREATE TABLE films (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    release_date DATE NOT NULL,
);

CREATE TABLE attribute_types (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255)
);

CREATE TABLE attributes (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    type_id INT,
    FOREIGN KEY (type_id) REFERENCES attribute_types (id)
);

CREATE TABLE attribute_values (
    id SERIAL PRIMARY KEY,
    film_id INT NOT NULL,
    attribute_id INT NOT NULL,
    text_value TEXT,
    integer_value INT,
    decimal_value DECIMAL(10, 2),
    date_value DATE,
    boolean_value BOOLEAN,
    FOREIGN KEY (film_id) REFERENCES films (id),
    FOREIGN KEY (attribute_id) REFERENCES attributes (id)
);

CREATE INDEX idx_films_release_date ON films (release_date, name);

CREATE INDEX idx_attributes_name ON attributes (name);

CREATE INDEX idx_attribute_values_film_id ON attribute_values (film_id);
CREATE INDEX idx_attribute_values_attribute_id ON attribute_values (attribute_id);
CREATE INDEX idx_attribute_values_text_value ON attribute_values (text_value);
CREATE INDEX idx_attribute_values_integer_value ON attribute_values (integer_value);
CREATE INDEX idx_attribute_values_decimal_value ON attribute_values (decimal_value);
CREATE INDEX idx_attribute_values_date_value ON attribute_values (date_value);
CREATE INDEX idx_attribute_values_boolean_value ON attribute_values (boolean_value);