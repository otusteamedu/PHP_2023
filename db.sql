CREATE DATABASE `cinema` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE `cinema`;

CREATE TABLE `cinema`.`genres`
(
    `id`         INT         NOT NULL AUTO_INCREMENT,
    `name`       VARCHAR(45) NOT NULL,
    `created_at` DATETIME    NOT NULL,
    `updated_at` DATETIME    NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `cinema`.`movies`
(
    `id`           INT          NOT NULL AUTO_INCREMENT,
    `title`        VARCHAR(45)  NOT NULL,
    `description`  VARCHAR(255) NOT NULL,
    `duration`     INT          NOT NULL,
    `rating`       TINYINT      NOT NULL,
    `poster`       VARCHAR(255) NOT NULL,
    `trailer`      VARCHAR(255) NOT NULL,
    `genre_id`     INT          NOT NULL,
    `release_date` DATE         NOT NULL,
    `created_at`   DATETIME     NOT NULL,
    `updated_at`   DATETIME     NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`genre_id`) REFERENCES `cinema`.`genres` (`id`)
);



CREATE TABLE `cinema`.`rooms`
(
    `id`         INT         NOT NULL AUTO_INCREMENT,
    `name`       VARCHAR(45) NOT NULL,
    `capacity`   INT         NOT NULL,
    `created_at` DATETIME    NOT NULL,
    `updated_at` DATETIME    NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `cinema`.`sessions`
(
    `id`         INT      NOT NULL AUTO_INCREMENT,
    `movie_id`   INT      NOT NULL,
    `room_id`    INT      NOT NULL,
    `start_time` DATETIME NOT NULL,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`movie_id`) REFERENCES `cinema`.`movies` (`id`),
    FOREIGN KEY (`room_id`) REFERENCES `cinema`.`rooms` (`id`)
);

CREATE TABLE `cinema`.`tickets`
(
    `id`          INT           NOT NULL AUTO_INCREMENT,
    `session_id`  INT           NOT NULL,
    `row_number`  INT           NOT NULL,
    `seat_number` INT           NOT NULL,
    `price`       DECIMAL(5, 2) NOT NULL,
    `created_at`  DATETIME      NOT NULL,
    `updated_at`  DATETIME      NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`session_id`) REFERENCES `cinema`.`sessions` (`id`)
);
