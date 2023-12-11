CREATE TABLE IF NOT EXISTS halls (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL
)

CREATE TABLE IF NOT EXISTS seats (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    hall_id INT NOT NULL,
    FOREIGN KEY (hall_id) REFERENCES halls (id)
)

CREATE TABLE IF NOT EXISTS movies (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    duration INT NOT NULL
)

CREATE TABLE IF NOT EXISTS shedule (
    id SERIAL PRIMARY KEY,
    movie_id INT NOT NULL,
    hall_id INT NOT NULL,
    start_time TIMESTAMP NOT NULL,
    FOREIGN KEY (movie_id) REFERENCES movies (id),
    FOREIGN KEY (hall_id) REFERENCES halls (id)
)

CREATE TABLE IF NOT EXISTS tickets (
    id SERIAL PRIMARY KEY,
    shedule_id INT NOT NULL,
    seat_id INT NOT NULL,
    price DECIMAL(8,2) NOT NULL,
    FOREIGN KEY (shedule_id) REFERENCES shedule (id),
    FOREIGN KEY (seat_id) REFERENCES seats (id)
)
