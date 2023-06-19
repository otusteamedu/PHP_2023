-- Create table "movies"
CREATE TABLE movies (
  id SERIAL PRIMARY KEY,
  title VARCHAR(255),
  -- Other columns for movie information
);

-- Create table "attributes"
CREATE TABLE attributes (
  id SERIAL PRIMARY KEY,
  name VARCHAR(255)
);

-- Create table "attribute_types"
CREATE TABLE attribute_types (
  id SERIAL PRIMARY KEY,
  name VARCHAR(255)
);

-- Create table "values"
CREATE TABLE values (
  id SERIAL PRIMARY KEY,
  attribute_id INT REFERENCES attributes(id),
  movie_id INT REFERENCES movies(id),
  attribute_type_id INT REFERENCES attribute_types(id),
  value TEXT
);
