-- Create table "movies"
CREATE TABLE movies (
  id SERIAL PRIMARY KEY,
  title TEXT NOT NULL
);

-- Create table "attributes"
CREATE TABLE attributes (
  id SERIAL PRIMARY KEY,
  name TEXT NOT NULL
);

-- Create table "attribute_types"
CREATE TABLE attribute_types (
  id SERIAL PRIMARY KEY,
  name TEXT NOT NULL
);

-- Create table "values"
CREATE TABLE values (
  id SERIAL PRIMARY KEY,
  attribute_id INT NOT NULL,
  movie_id INT NOT NULL,
  attribute_type_id INT NOT NULL,
  string_value TEXT,
  boolean_value BOOLEAN,
  date_value DATE,
  int_value INT,
  float_value FLOAT,
  FOREIGN KEY (attribute_id) REFERENCES attributes (id),
  FOREIGN KEY (movie_id) REFERENCES movies (id),
  FOREIGN KEY (attribute_type_id) REFERENCES attribute_types (id)
);