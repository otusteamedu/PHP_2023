CREATE TABLE films (
film_id SERIAL PRIMARY KEY,
title varchar(255) NOT NULL,
release_date date NOT NULL,
);

CREATE TABLE attributes (
attribute_id SERIAL PRIMARY KEY,
attribute_name varchar(255) NOT NULL,
attribute_type_id int NOT NULL,
);

CREATE TABLE attribute_types (
attribute_type_id SERIAL PRIMARY KEY,
attribute_type_name varchar(255) NOT NULL,
);

CREATE TABLE attribute_values (
film_id int NOT NULL,
attribute_id int NOT NULL,
attribute_value text,
date_value    date,
PRIMARY KEY (film_id, attribute_id),
FOREIGN KEY (film_id) REFERENCES films (film_id),
FOREIGN KEY (attribute_id) REFERENCES attributes (attribute_id)
);
