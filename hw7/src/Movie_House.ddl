CREATE DATABASE `movie_house` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

CREATE TABLE `movie_house`.`movies` (
	`id` 			INT 			NOT NULL 	AUTO_INCREMENT,
	`title` 		VARCHAR(255) 	NOT NULL,
	`year` 			YEAR 			NOT NULL,
	`genre` 		VARCHAR(255) 	NULL 		DEFAULT NULL,
	`duration` 		SMALLINT 		NULL 		DEFAULT NULL,
	PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `movie_house`.`movie_halls` (
	`id` 			INT 			NOT NULL 	AUTO_INCREMENT,
	`name` 			VARCHAR(255) 	NOT NULL,
	`capacity` 		SMALLINT 		NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `movie_house`.`sessions` (
	`id` 			INT 			NOT NULL 	AUTO_INCREMENT,
	`hall_id` 		INT 			NOT NULL,
	`movie_id` 		INT 			NOT NULL,
	`start_time` 	DATETIME 		NULL 		DEFAULT NULL,
	`price` 		FLOAT 			NOT NULL 	DEFAULT '0.00',
	PRIMARY KEY (`id`)
) ENGINE = InnoDB;

ALTER TABLE `movie_house`.`sessions`
	ADD KEY `hall_id` (`hall_id`),
	ADD KEY `movie_id` (`movie_id`),
	ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`hall_id`) REFERENCES `movie_halls` (`id`) ON DELETE CASCADE,
	ADD CONSTRAINT `sessions_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE;

CREATE TABLE `movie_house`.`viewers` (
	`id` 			INT 			NOT NULL	AUTO_INCREMENT,
	`name` 			VARCHAR(255) 	NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `movie_house`.`tickets` (
	`id` 			INT 			NOT NULL 	AUTO_INCREMENT,
	`code` 			CHAR(38) 		NOT NULL,
	`status` 		ENUM('Created','Canceled','Pending','Completed') NOT NULL DEFAULT 'Created',
	`viewer_id` 	INT 			NOT NULL,
	`session_id` 	INT 			NOT NULL,
	`created_at` 	DATETIME 		NOT NULL 	DEFAULT CURRENT_TIMESTAMP,
	`updated_at` 	DATETIME 		NULL 		DEFAULT NULL,
	PRIMARY KEY (`id`),
	UNIQUE `ticket_code` (`code`(38))
) ENGINE = InnoDB;

ALTER TABLE `movie_house`.`tickets`
  ADD KEY `viewer_id` (`viewer_id`),
  ADD KEY `session_id` (`session_id`),
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`viewer_id`) REFERENCES `viewers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE;