CREATE SCHEMA IF NOT EXISTS `cinemapark` CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `cinemapark`.`theater` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS `cinemapark`.`halls`
(
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `theater_id` INT NOT NULL
);

CREATE TABLE IF NOT EXISTS `cinemapark`.`seats`
(
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `seat_number` INT NOT NULL,
    `hall_id` INT NOT NULL
);

CREATE TABLE IF NOT EXISTS `cinemapark`.`movies`
(
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255),
    `description` TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS `cinemapark`.`sessions`
(
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `date` DATETIME NOT NULL,
    `hall_id` INT NOT NULL,
    `movie_id` INT NOT NULL
);

CREATE TABLE IF NOT EXISTS `cinemapark`.`tickets`
(
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `movie_session_id` INT NOT NULL,
    `seat_id` INT NOT NULL,
    `price` DOUBLE NOT NULL,
    `status_id` INT NOT NULL DEFAULT 1
);

CREATE TABLE IF NOT EXISTS `cinemapark`.`ticket_statuses`
(
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(25) NOT NULL
);