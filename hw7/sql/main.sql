CREATE TABLE IF NOT EXISTS halls (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL
)

CREATE TABLE IF NOT EXISTS movies (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    duration INT NOT NULL
)

CREATE TABLE IF NOT EXISTS sessions(
    id SERIAL PRIMARY KEY,
    hall_id INT NOT NULL,
    movie_id INT NOT NULL,
    start_time TIMESTAMP NOT NULL,
    FOREIGN KEY (hall_id) REFERENCES halls (id),
    FOREIGN KEY (movie_id) REFERENCES movies (id)
)

CREATE TABLE IF NOT EXISTS tickets (
    id SERIAL PRIMARY KEY,
    session_id INT NOT NULL,
    seat INT NOT NULL,
    price DECIMAL(8,2) NOT NULL,
    FOREIGN KEY (session_id) REFERENCES sessions (id)
)
