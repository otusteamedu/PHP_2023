CREATE DATABASE cars_db;

CREATE TABLE IF NOT EXISTS cars (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS models (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `car_id` INT NOT NULL, 
    `name` VARCHAR(255) NOT NULL
);


INSERT INTO cars (`name`) VALUES ('opel');
INSERT INTO cars (`name`) VALUES ('bmw');
INSERT INTO cars (`name`) VALUES ('renault');

INSERT INTO models (`car_id`, `name`) VALUES (1, 'signum');
INSERT INTO models (`car_id`, `name`) VALUES (1, 'vectra');
INSERT INTO models (`car_id`, `name`) VALUES (1, 'insignia');

INSERT INTO models (`car_id`, `name`) VALUES (2, 'i7');
INSERT INTO models (`car_id`, `name`) VALUES (2, 'm40');
INSERT INTO models (`car_id`, `name`) VALUES (2, 'x5');

INSERT INTO models (`car_id`, `name`) VALUES (3, 'kaptur');
INSERT INTO models (`car_id`, `name`) VALUES (3, 'arkana');
INSERT INTO models (`car_id`, `name`) VALUES (3, 'koleos');

CREATE TABLE IF NOT EXISTS cars (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS models (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `car_id` INT NOT NULL, 
    `name` VARCHAR(255) NOT NULL
);


INSERT INTO cars (`name`) VALUES ('opel');
INSERT INTO cars (`name`) VALUES ('bmw');
INSERT INTO cars (`name`) VALUES ('renault');

INSERT INTO models (`car_id`, `name`) VALUES (1, 'signum');
INSERT INTO models (`car_id`, `name`) VALUES (1, 'vectra');
INSERT INTO models (`car_id`, `name`) VALUES (1, 'insignia');

INSERT INTO models (`car_id`, `name`) VALUES (2, 'i7');
INSERT INTO models (`car_id`, `name`) VALUES (2, 'm40');
INSERT INTO models (`car_id`, `name`) VALUES (2, 'x5');

INSERT INTO models (`car_id`, `name`) VALUES (3, 'kaptur');
INSERT INTO models (`car_id`, `name`) VALUES (3, 'arkana');
INSERT INTO models (`car_id`, `name`) VALUES (3, 'koleos');

