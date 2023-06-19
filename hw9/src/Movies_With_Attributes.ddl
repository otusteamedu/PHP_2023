CREATE TABLE `movies` (
    `id`                INT             NOT NULL    AUTO_INCREMENT,
    `title`             VARCHAR(255)    NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `attribute_types` (
    `id`                INT             NOT NULL    AUTO_INCREMENT,
    `name`              VARCHAR(255)    NOT NULL,
    `type`              SET('TEXT','DATE','LOGICAL VALUE')  NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `attributes` (
    `id`                INT             NOT NULL    AUTO_INCREMENT,
    `name`              VARCHAR(255)    NOT NULL,
    `type_id`           INT             NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;
ALTER TABLE `attributes`
    ADD KEY `type_id` (`type_id`),
    ADD CONSTRAINT `attributes_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `attribute_types` (`id`) ON DELETE CASCADE;

CREATE TABLE `movies_attributes` (
    `id`                INT             NOT NULL    AUTO_INCREMENT,
    `movie_id`          INT             NOT NULL,
    `attribute_id`      INT             NOT NULL,
    `attribute_value`   TEXT            NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;
ALTER TABLE `movies_attributes`
  ADD KEY `movie_id` (`movie_id`),
  ADD KEY `attribute_id` (`attribute_id`),
  ADD CONSTRAINT `movies_attributes_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movies_attributes_ibfk_2` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE;

CREATE VIEW `data_for_marketing_dpt` AS
SELECT `m`.`title` AS `movie_title`, `at`.`name` AS `attribute_type`, `a`.`name` AS `attribute_name`, `ma`.`attribute_value` AS `attribute_value`
FROM `movies_attributes` `ma`
LEFT JOIN `movies` `m` ON `m`.`id` = `ma`.`movie_id`
LEFT JOIN `attributes` `a` ON `a`.`id` = `ma`.`attribute_id`
LEFT JOIN `attribute_types` `at` ON `at`.`id` = `a`.`type_id`;

CREATE VIEW `tasks_for_today_and_in_future` AS
SELECT `m`.`title`, `a`.`name`, `ma`.`attribute_value`
FROM `movies_attributes` AS `ma`
LEFT JOIN `movies` `m` ON `m`.`id` = `ma`.`movie_id`
LEFT JOIN `attributes` `a` ON `a`.`id` = `ma`.`attribute_id`
LEFT JOIN `attribute_types` `at` ON `at`.`id` = `a`.`type_id`
WHERE `at`.`type` = 'DATE'
    AND (
        `ma`.`attribute_value` = DATE_FORMAT(CURDATE(), '%m-%d-%Y')
        OR
        `ma`.`attribute_value` = DATE_FORMAT(CURDATE()+interval 20 day, '%m-%d-%Y')
    );
