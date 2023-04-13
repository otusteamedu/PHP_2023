CREATE TABLE movies (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       title VARCHAR(255) NOT NULL,
                       duration TIME NOT NULL,
                       genre VARCHAR(255) NOT NULL,
                       release_date DATE,
                       rating VARCHAR(255) NOT NULL
);
