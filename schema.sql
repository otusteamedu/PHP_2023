CREATE TABLE movies (
                        movie_id SERIAL PRIMARY KEY,
                        name VARCHAR(255) NOT NULL,
                        description TEXT,
                        day SMALLINT, -- Stores the day of the release date
                        month SMALLINT, -- Stores the month of the release date
                        year SMALLINT, -- Stores the year of the release date
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
                                  text_value TEXT,
                                  float_value FLOAT,
                                  int_value INT,
                                  date_value DATE,
                                  json_value JSON,
                                  FOREIGN KEY (movie_id) REFERENCES movies(movie_id),
                                  FOREIGN KEY (attribute_id) REFERENCES attributes(attribute_id)
);

/*CREATE INDEX idx_movie ON attribute_values (movie_id);
CREATE INDEX idx_attribute ON attribute_values (attribute_id);*/
