CREATE TABLE IF NOT EXISTS genres
(
    genre_id SERIAL PRIMARY KEY,
    title    VARCHAR(50)
);

CREATE TABLE IF NOT EXISTS movies
(
    movie_id SERIAL PRIMARY KEY,
    genre_id INT,
    title    VARCHAR(255),
    duration INT,
    rating   INT,
    FOREIGN KEY (genre_id) REFERENCES genres (genre_id)
);