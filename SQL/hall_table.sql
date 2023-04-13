CREATE TABLE halls (
                      id INT AUTO_INCREMENT PRIMARY KEY,
                      cinema_id INT,
                      name VARCHAR(255) NOT NULL,
                      capacity INT NOT NULL,
                      FOREIGN KEY (cinema_id) REFERENCES cinemas(id)
);