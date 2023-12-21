CREATE TABLE movies (
                        movie_id SERIAL PRIMARY KEY,
                        name VARCHAR(255) NOT NULL,
                        description TEXT,
                        release_date DATE,
                        duration INT
);

CREATE TABLE attribute_types (
                                 type_id SERIAL PRIMARY KEY,
                                 type_name VARCHAR(255) NOT NULL
);

CREATE TABLE attributes (
                            attribute_id SERIAL PRIMARY KEY,
                            type_id INT,
                            name VARCHAR(255) NOT NULL,
                            data_type VARCHAR(50) NOT NULL,
                            FOREIGN KEY (type_id) REFERENCES attribute_types(type_id)
);

CREATE TABLE attribute_values (
                                  value_id SERIAL PRIMARY KEY,
                                  movie_id INT,
                                  attribute_id INT,
                                  value TEXT,
                                  FOREIGN KEY (movie_id) REFERENCES movies(movie_id),
                                  FOREIGN KEY (attribute_id) REFERENCES attributes(attribute_id)
);

CREATE INDEX idx_movie ON attribute_values (movie_id);
CREATE INDEX idx_attribute ON attribute_values (attribute_id);

