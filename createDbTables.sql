CREATE DATABASE `otus_cinema1`;
USE `otus_cinema1`;
CREATE TABLE `room` (
                        `id` INT NOT NULL AUTO_INCREMENT,
                        `name` VARCHAR(50) NOT NULL DEFAULT '' COMMENT 'имя зала',
                        PRIMARY KEY (`id`)
)
COMMENT='кинозал'
;
CREATE TABLE `seat_class` (
                              `id` INT NOT NULL AUTO_INCREMENT,
                              `name` VARCHAR(50) NOT NULL DEFAULT '' COMMENT 'имя класса',
                              PRIMARY KEY (`id`)
)
COMMENT='класс мест';
CREATE TABLE `movie` (
                         `id` INT NOT NULL AUTO_INCREMENT,
                         `name` VARCHAR(50) NOT NULL DEFAULT '' COMMENT 'название фильма',
                         PRIMARY KEY (`id`)
)
COMMENT='фильмы';
CREATE TABLE `seat` (
                        `id` INT NOT NULL AUTO_INCREMENT,
                        `room_id` INT NOT NULL COMMENT 'id зала',
                        `seat_class` INT NOT NULL COMMENT 'класс места',
                        `row` INT NOT NULL COMMENT 'ряд',
                        `num` INT NOT NULL COMMENT 'место',
                        PRIMARY KEY (`id`),
                        UNIQUE INDEX `room_id_s` (`room_id`, `row`, `num`),
                        CONSTRAINT `FK__room` FOREIGN KEY (`room_id`) REFERENCES `room` (`id`) ON UPDATE RESTRICT ON DELETE RESTRICT,
                        CONSTRAINT `FK__seat_class` FOREIGN KEY (`seat_class`) REFERENCES `seat_class` (`id`) ON UPDATE RESTRICT ON DELETE RESTRICT
)
COMMENT='места в залах';
CREATE TABLE `schedule` (
                            `id` INT NOT NULL AUTO_INCREMENT,
                            `room_id` INT NULL COMMENT 'зал',
                            `movie_id` INT NULL COMMENT 'фильм',
                            `datetime` TIMESTAMP NULL COMMENT 'время сеанса',
                            PRIMARY KEY (`id`),
                            UNIQUE INDEX `room_id_schedule` (`room_id`, `datetime`),
                            CONSTRAINT `FK__room_s` FOREIGN KEY (`room_id`) REFERENCES `room` (`id`),
                            CONSTRAINT `FK__movie_s` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`)
)
COMMENT='расписание сеансов';
CREATE TABLE `seat_price` (
                              `id` INT NOT NULL AUTO_INCREMENT,
                              `seat_class_id` INT NOT NULL COMMENT 'класс места',
                              `schedule_id` INT NOT NULL COMMENT 'сеанс',
                              `price` DECIMAL(20,2) NOT NULL DEFAULT 0 COMMENT 'цена',
                              PRIMARY KEY (`id`),
                              UNIQUE INDEX `seat_class_id_sp` (`seat_class_id`, `schedule_id`),
                              CONSTRAINT `FK__seat_class_sp` FOREIGN KEY (`seat_class_id`) REFERENCES `seat_class` (`id`),
                              CONSTRAINT `FK__schedule_sp` FOREIGN KEY (`schedule_id`) REFERENCES `schedule` (`id`)
)
COMMENT='цена мест';
CREATE TABLE `sold_ticket` (
                               `id` INT NOT NULL AUTO_INCREMENT,
                               `schedule_id` INT NULL COMMENT 'сеанс',
                               `seat_id` INT NULL COMMENT 'место',
                               PRIMARY KEY (`id`),
                               UNIQUE INDEX `schedule_id_st` (`schedule_id`, `seat_id`),
                               CONSTRAINT `FK__schedule_st` FOREIGN KEY (`schedule_id`) REFERENCES `schedule` (`id`),
                               CONSTRAINT `FK__seat_st` FOREIGN KEY (`seat_id`) REFERENCES `seat` (`id`)
)
COMMENT='проданные билеты';
