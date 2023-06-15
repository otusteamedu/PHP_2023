CREATE TABLE cinema (
    id int NOT NULL AUTO_INCREMENT,
    title VARCHAR(128),
    description TEXT,
    address VARCHAR(128),
    PRIMARY KEY (id)
);
CREATE TABLE cinema_halls (
    id int NOT NULL AUTO_INCREMENT,
    cinema_id INT,
    title VARCHAR(128),
    description TEXT,
    PRIMARY KEY (id),
    FOREIGN KEY (cinema_id) REFERENCES cinema(id)
);
CREATE TABLE movies (
    id int NOT NULL AUTO_INCREMENT,
    title VARCHAR(128),
    description TEXT,
    movie_time TIME,
    PRIMARY KEY (id)
);
CREATE TABLE movie_sessions (
    id int NOT NULL AUTO_INCREMENT,
    cinema_halls_id INT,
    movies_id INT,
    time_start TIMESTAMP,
    time_finish TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (cinema_halls_id) REFERENCES cinema_halls(id),
    FOREIGN KEY (movies_id) REFERENCES movies(id)
);
CREATE TABLE clients (
    id int NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(128),
    last_name VARCHAR(128),
    email VARCHAR(128),
    phone_number VARCHAR(128),
    PRIMARY KEY (id)
);
CREATE TABLE seatings (
    id int NOT NULL AUTO_INCREMENT,
    cinema_halls_id INT,
    row INT,
    seatings_count INT,
    PRIMARY KEY (id),
    FOREIGN KEY (cinema_halls_id) REFERENCES cinema_halls(id)
);
CREATE TABLE sales_ticket (
    id int NOT NULL AUTO_INCREMENT,
    seatings_id INT,
    movie_sessions_id INT,
    clients_id INT,
    price FLOAT,
    PRIMARY KEY (id),
    FOREIGN KEY (seatings_id) REFERENCES seatings(id),
    FOREIGN KEY (movie_sessions_id) REFERENCES movie_sessions(id),
    FOREIGN KEY (clients_id) REFERENCES clients(id)
);