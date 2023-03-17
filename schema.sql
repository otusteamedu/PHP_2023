
CREATE TABLE films (
   id SERIAL PRIMARY KEY,
   name VARCHAR(256) NOT NULL,
   release_date DATE NOT NULL,
   country_production VARCHAR(50) NOT NULL,
   duration INT NOT NULL,
   description TEXT
);

CREATE TABLE attribute_types (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    data_type VARCHAR(50) NOT NULL
);

CREATE TABLE attributes (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    required BOOLEAN DEFAULT FALSE,
    attribute_type_id INT NOT NULL,
    CONSTRAINT c_fk_attribute_type FOREIGN KEY (attribute_type_id) REFERENCES attribute_types (id) ON DELETE RESTRICT
);

CREATE TABLE film_attribute_values (
  id SERIAL PRIMARY KEY,
  text_value TEXT,
  char_value VARCHAR(256),
  integer_value INT,
  float_value FLOAT4,
  numeric_value NUMERIC(4,2),
  bool_value BOOL,
  date_value DATE,
  film_id INT NOT NULL,
  attribute_id INT NOT NULL,
  CONSTRAINT c_fk_film FOREIGN KEY (film_id) REFERENCES films (id) ON DELETE RESTRICT,
  CONSTRAINT c_fk_attribute FOREIGN KEY (attribute_id) REFERENCES attributes (id) ON DELETE RESTRICT
);

CREATE INDEX film_name_idx ON films (name);
CREATE INDEX attribute_type_name_idx ON attribute_types (name);
CREATE INDEX fav_date_idx ON film_attribute_values (date_value);
