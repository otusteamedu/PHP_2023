CREATE TABLE IF NOT EXISTS movies
(
    id SERIAL PRIMARY KEY NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    rate NUMERIC(8,2) NOT NULL,
    duration INT NOT NULL,
    price NUMERIC(8,2) NOT NULL
);

CREATE TABLE IF NOT EXISTS entity_attribute_types
(
    id SERIAL PRIMARY KEY NOT NULL,
    name VARCHAR(255) NOT NULL,
    datatype VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS entity_attributes
(
    id SERIAL PRIMARY KEY NOT NULL,
    name VARCHAR(255) NOT NULL,
    attribute_type INTEGER NOT NULL,
    FOREIGN KEY (attribute_type) REFERENCES entity_attribute_types (id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS entity_attribute_values
(
    entity_id INTEGER NOT NULL,
    attribute_id INTEGER NOT NULL,
    value_string VARCHAR(255) DEFAULT NULL,
    value_float NUMERIC(8,2) DEFAULT NULL,
    value_date DATE DEFAULT NULL,
    value_timestamp TIMESTAMP DEFAULT NULL,
    value_boolean BOOLEAN DEFAULT NULL,
    FOREIGN KEY (entity_id) REFERENCES movies(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (attribute_id) REFERENCES entity_attributes(id) ON DELETE CASCADE ON UPDATE CASCADE
);