CREATE TABLE cinema (
                        id int NOT NULL AUTO_INCREMENT,
                        title VARCHAR(128),
                        address VARCHAR(128),
                        PRIMARY KEY (id)
);

CREATE TABLE cinema_halls (
                              id int NOT NULL AUTO_INCREMENT,
                              cinema_id INT,
                              title VARCHAR(128),
                              PRIMARY KEY (id),
                              FOREIGN KEY (cinema_id) REFERENCES cinema(id)
);

CREATE TABLE movies (
                        id int NOT NULL AUTO_INCREMENT,
                        title VARCHAR(128),
                        description TEXT,
                        movie_time_minutes INT,
                        PRIMARY KEY (id)
);

CREATE TABLE movie_session (
                               id int NOT NULL AUTO_INCREMENT,
                               cinema_halls_id INT,
                               movies_id INT,
                               time_start DATETIME,
                               time_finish DATETIME,
                               PRIMARY KEY (id),
                               FOREIGN KEY (cinema_halls_id) REFERENCES cinema_halls(id),
                               FOREIGN KEY (movies_id) REFERENCES movies(id)
);

CREATE TABLE person (
                        id int NOT NULL AUTO_INCREMENT,
                        firstname VARCHAR(128),
                        lastname VARCHAR(128),
                        phone VARCHAR(128),
                        PRIMARY KEY (id)
);

CREATE TABLE seating (
                         id int NOT NULL AUTO_INCREMENT,
                         cinema_halls_id INT,
                         row SMALLINT,
                         number SMALLINT,
                         PRIMARY KEY (id),
                         FOREIGN KEY (cinema_halls_id) REFERENCES cinema_halls(id)
);

CREATE TABLE ticket (
                        id int NOT NULL AUTO_INCREMENT,
                        seating_id INT,
                        movie_session_id INT,
                        person_id INT,
                        price SMALLINT,
                        PRIMARY KEY (id),
                        FOREIGN KEY (seating_id) REFERENCES seating(id),
                        FOREIGN KEY (movie_session_id) REFERENCES movie_session(id),
                        FOREIGN KEY (person_id) REFERENCES person(id)
);