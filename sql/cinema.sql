DO $$DECLARE
  r RECORD;
BEGIN
  FOR r IN (SELECT tablename FROM pg_tables WHERE schemaname = current_schema()) LOOP
    EXECUTE 'DROP TABLE IF EXISTS ' || quote_ident(r.tablename) || ' CASCADE';
  END LOOP;
END$$;

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

-- Create table "ticket_sales"
CREATE TABLE ticket_sales (
  id SERIAL PRIMARY KEY,
  movie_id INT NOT NULL,
  sale_date DATE NOT NULL,
  quantity INT NOT NULL,
  FOREIGN KEY (movie_id) REFERENCES movies (id)
);

CREATE TABLE hall_schema (
  id SERIAL PRIMARY KEY,
  seat_number INT NOT NULL,
  row_number INT NOT NULL,
  is_vip BOOLEAN DEFAULT false,
  CONSTRAINT unique_seat_number_row_number UNIQUE (seat_number, row_number)
);

INSERT INTO attributes (name) VALUES ('Время начала');

INSERT INTO attribute_types (name) VALUES ('Дата/Время');

ALTER TABLE values ADD CONSTRAINT unique_start_time_attribute_type
  UNIQUE (attribute_id, attribute_type_id)
  DEFERRABLE INITIALLY DEFERRED;