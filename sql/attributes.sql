CREATE TABLE attributes (
                            id SERIAL PRIMARY KEY,
                            attribute_type_id INTEGER NOT NULL REFERENCES attribute_types(id),
                            attribute VARCHAR(255) NOT NULL
);
