CREATE TABLE Screenings (
                           id INT AUTO_INCREMENT PRIMARY KEY,
                           movie_id INT,
                           hall_id INT,
                           start_time DATETIME NOT NULL,
                           end_time DATETIME NOT NULL,
                           ticket_price INT NOT NULL,
                           FOREIGN KEY (movie_id) REFERENCES Movie(movie_id),
                           FOREIGN KEY (hall_id) REFERENCES Hall(hall_id)
);