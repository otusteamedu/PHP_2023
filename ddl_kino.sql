CREATE TABLE `cinema_hall` (
   `id` int NOT NULL AUTO_INCREMENT,
   `name` varchar(255) NOT NULL,
   PRIMARY KEY (`id`)
);

CREATE TABLE `place` (
    `id` int NOT NULL AUTO_INCREMENT,
    `cinema_hall_id` int NOT NULL,
    `raw` int NOT NULL,
    `place` int NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `session` (
   `id` int NOT NULL AUTO_INCREMENT,
   `cinema_hall_id` int NOT NULL,
   `film_id` int NOT NULL,
   `started_at` DATETIME NOT NULL,
   `price` int NOT NULL,
   PRIMARY KEY (`id`)
);

CREATE TABLE `film` (
    `id` int NOT NULL AUTO_INCREMENT,
    `title` varchar(255) NOT NULL,
    `description` TEXT,
    `duration` int,
    `year` int,
    PRIMARY KEY (`id`)
);

CREATE TABLE `order` (
     `id` int NOT NULL AUTO_INCREMENT,
     `user_id` int NOT NULL,
     `session_id` int NOT NULL,
     `place_id` int NOT NULL,
     PRIMARY KEY (`id`)
);

CREATE TABLE `user` (
    `id` int NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `phone` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
);

ALTER TABLE `session` ADD CONSTRAINT `session_fk0` FOREIGN KEY (`cinema_hall_id`) REFERENCES `cinema_hall`(`id`);

ALTER TABLE `session` ADD CONSTRAINT `session_fk1` FOREIGN KEY (`film_id`) REFERENCES `film`(`id`);

ALTER TABLE `place` ADD CONSTRAINT `place_fk0` FOREIGN KEY (`cinema_hall_id`) REFERENCES `cinema_hall`(`id`);

ALTER TABLE `place` ADD CONSTRAINT `place_uidx0` UNIQUE KEY (`cinema_hall_id`, `raw`, `place`);

ALTER TABLE `order` ADD CONSTRAINT `order_fk0` FOREIGN KEY (`user_id`) REFERENCES `user`(`id`);

ALTER TABLE `order` ADD CONSTRAINT `order_fk1` FOREIGN KEY (`session_id`) REFERENCES `session`(`id`);

ALTER TABLE `order` ADD CONSTRAINT `order_fk2` FOREIGN KEY (`place_id`) REFERENCES `place`(`id`);
