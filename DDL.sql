CREATE TABLE `movies` (
                          `id` BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
                          `title` VARCHAR(255) NOT NULL,
                          `description` TEXT,
                          `duration` INT NOT NULL,
                          `price` NUMERIC(10, 2) NOT NULL
);

CREATE TABLE `halls` (
                         `id` BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
                         `name` VARCHAR(255) NOT NULL,
                         `koef` FLOAT NOT NULL
);

CREATE TABLE `places` (
                          `id` BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
                          `halls_id` BIGINT NOT NULL,
                          `row` INT NOT NULL,
                          `place` INT NOT NULL,
                          `koef` FLOAT NOT NULL
);

CREATE TABLE `session` (
                           `id` BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
                           `datetime` timestamp NOT NULL,
                           `movie_id` BIGINT NOT NULL,
                           `hall_id` BIGINT NOT NULL,
                           `koef` FLOAT NOT NULL
);

CREATE TABLE `tickets` (
                           `id` BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
                           `place_id` BIGINT NOT NULL,
                           `session_id` BIGINT NOT NULL
);

CREATE TABLE `orders` (
                          `id` BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
                          `pay` BOOL
);

CREATE TABLE `basket_item` (
                               `id` BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
                               `tickets_id` BIGINT UNIQUE NOT NULL,
                               `orders_id` BIGINT NOT NULL
);

CREATE UNIQUE INDEX `places_index_0` ON `places` (`halls_id`, `row`, `place`);

CREATE UNIQUE INDEX `tickets_index_1` ON `tickets` (`place_id`, `session_id`);

ALTER TABLE `places` ADD FOREIGN KEY (`halls_id`) REFERENCES `halls` (`id`);

ALTER TABLE `session` ADD FOREIGN KEY (`hall_id`) REFERENCES `halls` (`id`);

ALTER TABLE `session` ADD FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`);

ALTER TABLE `tickets` ADD FOREIGN KEY (`place_id`) REFERENCES `places` (`id`);

ALTER TABLE `tickets` ADD FOREIGN KEY (`session_id`) REFERENCES `session` (`id`);

ALTER TABLE `basket_item` ADD FOREIGN KEY (`orders_id`) REFERENCES `orders` (`id`);

ALTER TABLE `basket_item` ADD FOREIGN KEY (`tickets_id`) REFERENCES `tickets` (`id`);
