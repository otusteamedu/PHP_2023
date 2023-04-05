CREATE TABLE values (
                        id SERIAL PRIMARY KEY,
                        movie_id INTEGER NOT NULL REFERENCES movies(id),
                        attribute_id INTEGER NOT NULL REFERENCES attributes(id),
                        text_value TEXT,
                        boolean_value BOOLEAN,
                        date_value DATE,
                        float_value FLOAT,
                        int_value INT
);
