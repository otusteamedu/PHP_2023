CREATE TABLE IF NOT EXISTS movies (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    duration INT NOT NULL
);

CREATE TABLE IF NOT EXISTS attribute_types (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS attributes (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    type_id INT NOT NULL,
    FOREIGN KEY (type_id) REFERENCES attribute_types (id)
);

CREATE TABLE IF NOT EXISTS attribute_values (
    movie_id INT NOT NULL,
    attribute_id INT NOT NULL,
    val_text TEXT,
    val_bool BOOLEAN,
    val_int INT,
    val_date DATE,
    FOREIGN KEY (movie_id) REFERENCES movies (id),
    FOREIGN KEY (attribute_id) REFERENCES attributes (id)
);
