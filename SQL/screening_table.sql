CREATE TABLE screenings (
                           id INT AUTO_INCREMENT PRIMARY KEY,
                           movie_id INT,
                           hall_id INT,
                           start_time DATETIME NOT NULL,
                           end_time DATETIME NOT NULL,
                           ticket_price INT NOT NULL,
                           FOREIGN KEY (movie_id) REFERENCES movie(id),
                           FOREIGN KEY (hall_id) REFERENCES hall(id)
);