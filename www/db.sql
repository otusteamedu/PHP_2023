DROP TABLE IF EXISTS `halls`;
CREATE TABLE `halls`
(
    `id` int NOT NULL AUTO_INCREMENT,
    `name` varchar(50) NOT NULL,
    PRIMARY KEY (`id`)
);

INSERT INTO `halls` (`id`, `name`)
VALUES (1, 'Первый зал'), (2, 'Второй зал');


DROP TABLE IF EXISTS `movies`;
CREATE TABLE `movies`
(
    `id` int NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `duration` time NOT NULL,
    `production_year` year NOT NULL,
    PRIMARY KEY (`id`)
);

INSERT INTO `movies` (`id`, `name`, `duration`, `production_year`)
VALUES (1, 'Фильм первый', '01:45:00', '2023'), (2, 'Фильм второй', '02:45:00', '2024');


DROP TABLE IF EXISTS `seats`;
CREATE TABLE `seats`
(
    `id` int NOT NULL AUTO_INCREMENT,
    `seat_number` varchar(10) NOT NULL,
    `row_number` int NOT NULL,
    PRIMARY KEY (`id`)
);

INSERT INTO `seats` (`id`, `seat_number`, `row_number`)
VALUES (1, 'А1', 1), (2, 'А2', 1), (3, 'A2', 1), (4, 'A3', 1), (5, 'A4', 1), (6, 'A1', 1), (7, 'A3', 1), (8, 'A4', 1);


DROP TABLE IF EXISTS `seat_map`;
CREATE TABLE `seat_map`
(
    `id` int NOT NULL AUTO_INCREMENT,
    `hall_id` int NOT NULL,
    `seat_id` int NOT NULL,
    PRIMARY KEY (`id`),
    KEY `seat_id` (`seat_id`),
    KEY `hall_id` (`hall_id`),
    CONSTRAINT `seat_map_ibfk_2` FOREIGN KEY (`seat_id`) REFERENCES `seats` (`id`) ON DELETE CASCADE,
    CONSTRAINT `seat_map_ibfk_4` FOREIGN KEY (`hall_id`) REFERENCES `halls` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO `seat_map` (`id`, `hall_id`, `seat_id`)
VALUES (1, 1, 1), (2, 1, 2), (3, 1,	3), (4,	1, 4), (5, 2, 1), (6, 2, 2), (7, 2,	3), (8,	2, 4);


DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions`
(
    `id` int NOT NULL AUTO_INCREMENT,
    `datetime` datetime NOT NULL,
    `hall_id` int NOT NULL,
    `movie_id` int NOT NULL,
    PRIMARY KEY (`id`),
    KEY `hall_id` (`hall_id`),
    KEY `movie_id` (`movie_id`),
    CONSTRAINT `sessions_ibfk_3` FOREIGN KEY (`hall_id`) REFERENCES `halls` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `sessions_ibfk_5` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO `sessions` (`id`, `datetime`, `hall_id`, `movie_id`)
VALUES (1, '2024-01-01 14:30:00', 1, 1), (2, '2024-01-02 14:30:00',	2, 2);


DROP TABLE IF EXISTS `session_price`;
CREATE TABLE `session_price`
(
    `id` int NOT NULL AUTO_INCREMENT,
    `seat_map_id` int NOT NULL,
    `session_id` int NOT NULL,
    `price` decimal(10,0) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `seat_map_id` (`seat_map_id`),
    KEY `session_id` (`session_id`),
    CONSTRAINT `session_price_ibfk_3` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `session_price_ibfk_5` FOREIGN KEY (`seat_map_id`) REFERENCES `seat_map` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO `session_price` (`id`, `seat_map_id`, `session_id`, `price`)
VALUES (5, 1, 1, 200), (6, 2, 1, 300), (7, 3, 2, 100);


DROP TABLE IF EXISTS `tickets`;
CREATE TABLE `tickets`
(
    `id` int NOT NULL AUTO_INCREMENT,
    `session_id` int NOT NULL,
    `status` enum('reserved','sold','canceled') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
    `seat_map_id` int NOT NULL,
    `date_purchase` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
    `price` decimal(10,0) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `session_id` (`session_id`),
    KEY `seat_id` (`seat_map_id`),
    CONSTRAINT `tickets_ibfk_4` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `tickets_ibfk_5` FOREIGN KEY (`seat_map_id`) REFERENCES `seat_map` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO `tickets` (`id`, `session_id`, `status`, `seat_map_id`, `date_purchase`, `price`)
VALUES (11,	1, 'sold', 1, '2024-01-07 14:19:12', 200), (12,	1, 'canceled', 2, '2024-01-07 14:19:47', 300);