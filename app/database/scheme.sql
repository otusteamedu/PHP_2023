CREATE TABLE IF NOT EXISTS application_form (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    message VARCHAR(255) NOT NULL,
    status_id INT NOT NULL,
    FOREIGN KEY (status_id) REFERENCES status(id)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS status (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    UNIQUE KEY name (name)
) ENGINE=INNODB;

INSERT INTO status (`name`) VALUES ('In work'), ('Done');
