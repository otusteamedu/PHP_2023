CREATE DATABASE IF NOT EXISTS cinema;
USE cinema;

# тип зала
CREATE TABLE IF NOT EXISTS type_hall (
    id INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    description TEXT,
    updated_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)  ENGINE=INNODB;

# схема зала
CREATE TABLE IF NOT EXISTS scheme_hall (
    id INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    description TEXT,
    updated_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)  ENGINE=INNODB;


# зоны рассадки
CREATE TABLE IF NOT EXISTS seating_area (
    id INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    updated_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)  ENGINE=INNODB;


# рассадка
CREATE TABLE IF NOT EXISTS seating_arrangements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    `row` INT NOT NULL,
    place INT NOT NULL,
    seating_area_id INT NOT NULL,
    scheme_hall_id INT NOT NULL,
    updated_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (seating_area_id) REFERENCES seating_area(id),
    FOREIGN KEY (scheme_hall_id) REFERENCES scheme_hall(id)
)  ENGINE=INNODB;


# зал
CREATE TABLE IF NOT EXISTS hall (
    id INT AUTO_INCREMENT PRIMARY KEY,
    number_of_seats INT NOT NULL,
    type_id INT NOT NULL,
    scheme_id INT NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (type_id) REFERENCES type_hall(id),
    FOREIGN KEY (scheme_id) REFERENCES scheme_hall(id)
)  ENGINE=INNODB;


# кино
CREATE TABLE IF NOT EXISTS `movie` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    description TEXT,
    updated_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)  ENGINE=INNODB;


# тип сеанса
CREATE TABLE IF NOT EXISTS type_session (
    id INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    description TEXT,
    updated_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)  ENGINE=INNODB;


# сеанс
CREATE TABLE IF NOT EXISTS `session` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hall_id INT NOT NULL,
    movie_id INT NOT NULL,
    type_id INT NOT NULL,
    start_time TIMESTAMP NOT NULL,
    end_time TIMESTAMP NOT NULL,
    updated_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (hall_id) REFERENCES hall(id),
    FOREIGN KEY (movie_id) REFERENCES movie(id),
    FOREIGN KEY (type_id) REFERENCES type_session(id)
)  ENGINE=INNODB;


# клиент
CREATE TABLE IF NOT EXISTS client (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    first_name VARCHAR(255) NOT NULL,
    middle_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    updated_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)  ENGINE=INNODB;


# билет
CREATE TABLE IF NOT EXISTS ticket (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    session_id INT NOT NULL,
    price DECIMAL(8,2) NOT NULL,
    seating_arrangements_id INT NOT NULL,
    FOREIGN KEY (client_id) REFERENCES client(id),
    FOREIGN KEY (session_id) REFERENCES `session`(id),
    FOREIGN KEY (seating_arrangements_id) REFERENCES seating_arrangements(id),
    updated_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)  ENGINE=INNODB;
