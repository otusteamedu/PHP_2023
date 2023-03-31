CREATE TABLE Screening (
                           screening_id INT AUTO_INCREMENT PRIMARY KEY,
                           movie_id INT,
                           hall_id INT,
                           start_time DATETIME NOT NULL,
                           end_time DATETIME NOT NULL,
                           ticket_price DECIMAL(10,2) NOT NULL,
                           FOREIGN KEY (movie_id) REFERENCES Movie(movie_id),
                           FOREIGN KEY (hall_id) REFERENCES Hall(hall_id)
);