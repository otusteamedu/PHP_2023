CREATE DATABASE IF NOT EXISTS cinema;
USE cinema;


# справочник цен
CREATE TABLE IF NOT EXISTS prices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    price DECIMAL(8,2) NOT NULL,
    updated_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)  ENGINE=INNODB;


# коэффициенты, которые будут влиять на итоговую стоимость в билете
CREATE TABLE IF NOT EXISTS coefficients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    `value` FLOAT NOT NULL,
    updated_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)  ENGINE=INNODB;


# типы залов
CREATE TABLE IF NOT EXISTS type_halls (
    id INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    coefficient_id INT,
    description TEXT,
    updated_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (coefficient_id) REFERENCES coefficients(id)
)  ENGINE=INNODB;


# схемы залов
CREATE TABLE IF NOT EXISTS scheme_halls (
    id INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    description TEXT,
    updated_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)  ENGINE=INNODB;


# зоны рассадки
CREATE TABLE IF NOT EXISTS seating_zones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    coefficient_id INT,
    updated_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (coefficient_id) REFERENCES coefficients(id)
)  ENGINE=INNODB;


# рассадка
CREATE TABLE IF NOT EXISTS seating_arrangements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    `row` INT NOT NULL,
    place INT NOT NULL,
    zone_id INT NOT NULL,
    scheme_id INT NOT NULL,
    updated_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (zone_id) REFERENCES seating_zones(id),
    FOREIGN KEY (scheme_id) REFERENCES scheme_halls(id)
)  ENGINE=INNODB;


# залы
CREATE TABLE IF NOT EXISTS halls (
    id INT AUTO_INCREMENT PRIMARY KEY,
    number_of_seats INT NOT NULL,
    type_id INT NOT NULL,
    scheme_id INT NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (type_id) REFERENCES type_halls(id),
    FOREIGN KEY (scheme_id) REFERENCES scheme_halls(id)
)  ENGINE=INNODB;


# жанры фильмов
CREATE TABLE IF NOT EXISTS movie_genres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    description TEXT,
    updated_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)  ENGINE=INNODB;


# категории фильмов
CREATE TABLE IF NOT EXISTS movie_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    description TEXT,
    updated_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)  ENGINE=INNODB;


# фильмы
CREATE TABLE IF NOT EXISTS `movies` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    genre_id INT NOT NULL,
    category_id INT NOT NULL,
    description TEXT,
    updated_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (genre_id) REFERENCES movie_genres(id),
    FOREIGN KEY (category_id) REFERENCES movie_categories(id)
)  ENGINE=INNODB;


# типы сеанса
CREATE TABLE IF NOT EXISTS type_sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    description TEXT,
    coefficient_id INT,
    updated_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (coefficient_id) REFERENCES coefficients(id)
)  ENGINE=INNODB;


# сеансы
CREATE TABLE IF NOT EXISTS `sessions` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hall_id INT NOT NULL,
    movie_id INT NOT NULL,
    type_id INT NOT NULL,
    start_time TIMESTAMP NOT NULL,
    end_time TIMESTAMP NOT NULL,
    updated_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (hall_id) REFERENCES halls(id),
    FOREIGN KEY (movie_id) REFERENCES movies(id),
    FOREIGN KEY (type_id) REFERENCES type_sessions(id)
)  ENGINE=INNODB;


# клиенты
CREATE TABLE IF NOT EXISTS clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    first_name VARCHAR(255) NOT NULL,
    middle_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    updated_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)  ENGINE=INNODB;

# билеты
CREATE TABLE IF NOT EXISTS tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    session_id INT NOT NULL,
    price DECIMAL(8,2) NOT NULL,
    seating_arrangements_id INT NOT NULL,
    FOREIGN KEY (client_id) REFERENCES clients(id),
    FOREIGN KEY (session_id) REFERENCES `sessions`(id),
    FOREIGN KEY (seating_arrangements_id) REFERENCES seating_arrangements(id),
    updated_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)  ENGINE=INNODB;
