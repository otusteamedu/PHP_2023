CREATE TABLE MovieDirectors (
                                movie_id INT,
                                director_id INT,
                                PRIMARY KEY (movie_id, director_id),
                                FOREIGN KEY (movie_id) REFERENCES Movies(id),
                                FOREIGN KEY (director_id) REFERENCES Directors(id)
);