CREATE TABLE MovieActors (
                             movie_id INT,
                             actor_id INT,
                             PRIMARY KEY (movie_id, actor_id),
                             FOREIGN KEY (movie_id) REFERENCES Movies(id),
                             FOREIGN KEY (actor_id) REFERENCES Actors(id)
);