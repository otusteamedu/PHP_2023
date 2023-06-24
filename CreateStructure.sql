
CREATE DATABASE cinema;
USE cinema;

CREATE TABLE `Films` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `duration` time NOT NULL,
    `cost` decimal(20,6) NOT NULL,
    PRIMARY KEY (`id`)
);


CREATE TABLE `Halls` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `seatsCountInRow` int(11) NOT NULL,
    `rowsCount` int(11) NOT NULL,
    PRIMARY KEY (`id`)
);


CREATE TABLE `Sessions` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `hallId` int(11) NOT NULL,
    `filmId` int(11) NOT NULL,
    `beginTime` datetime NOT NULL,
    `costCoeff` decimal(20,6) NOT NULL DEFAULT 1.000000,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`hallId`) REFERENCES `Halls` (`id`),
    FOREIGN KEY (`filmId`) REFERENCES `Films` (`id`)
);


CREATE TABLE `soldTickets` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `sessionId` int(11) NOT NULL,
    `seatNumber` int(11) NOT NULL,
    `rowNumber` int(11) NOT NULL,
    `clientFio` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `cost` decimal(20,6) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`sessionId`) REFERENCES `Sessions` (`id`)
);