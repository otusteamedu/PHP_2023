/*
 * Кинотеатр имеет несколько залов, в каждом зале идет несколько разных сеансов, клиенты могут купить билеты на сеансы
*/

/* Залы */
CREATE TABLE `hall`
(
    `id`   int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
);

/* Места */
CREATE TABLE `place`
(
    `id`      int(11) NOT NULL AUTO_INCREMENT,
    `hall_id` int(11) NOT NULL,
    `row`     int(5) NOT NULL,
    `place`   int(5) NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `FK_place_hall` FOREIGN KEY (`hall_id`) REFERENCES `hall` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

/* Фильмы */
CREATE TABLE `movie`
(
    `id`         int(11) NOT NULL AUTO_INCREMENT,
    `name`       varchar(255) NOT NULL,
    `start_date` date         NOT NULL,
    `duration`   int(11) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
);

/* Сеансы */
CREATE TABLE `session`
(
    `id`       int(11) NOT NULL AUTO_INCREMENT,
    `hall_id`  int(11) NOT NULL,
    `movie_id` int(11) NOT NULL,
    `time`     timestamp NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `FK_session_hall` FOREIGN KEY (`hall_id`) REFERENCES `hall` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_session_movie` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

/* Цены на сеансы */
CREATE TABLE `session_price`
(
    `id`         int(11) NOT NULL AUTO_INCREMENT,
    `session_id` int(11) NOT NULL,
    `place_id`   int(11) NOT NULL,
    `price`      int(6) NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `FK_session_price_session` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_session_price_place` FOREIGN KEY (`place_id`) REFERENCES `place` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

/* Клиенты */
CREATE TABLE `client`
(
    `id`       int(11) NOT NULL AUTO_INCREMENT,
    `name`     varchar(255) NOT NULL,
    `surname`  varchar(255) NULL,
    `lastname` varchar(255) NULL,
    `email`    varchar(255) NOT NULL,
    `phone`    int(11) NOT NULL,
    PRIMARY KEY (`id`)
);

/* Билеты */
CREATE TABLE `ticket`
(
    `id`               int(11) NOT NULL AUTO_INCREMENT,
    `session_price_id` int(11) NOT NULL,
    `client_id`        int(11) NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `FK_ticket_session_price` FOREIGN KEY (`session_price_id`) REFERENCES `session_price` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

