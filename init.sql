CREATE DATABASE IF NOT EXISTS cinema;

USE cinema;

DROP TABLE IF EXISTS tickets;
DROP TABLE IF EXISTS seances;
DROP TABLE IF EXISTS films;
DROP TABLE IF EXISTS genres;
DROP TABLE IF EXISTS halls;

CREATE TABLE genres
(
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL
);

CREATE TABLE films
(
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description VARCHAR(1000) NOT NULL,
    image_preview VARCHAR(255) NOT NULL,
    teaser_preview VARCHAR(255) NOT NULL,
    genre_id INT,
    year YEAR(4),
    FOREIGN KEY (genre_id) REFERENCES genres (id) ON DELETE SET NULL
);

CREATE TABLE halls
(
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    seats INTEGER NOT NULL
);

CREATE TABLE seances
(
    id INT PRIMARY KEY AUTO_INCREMENT,
    date DATE NOT NULL,
    start_at TIME NOT NULL,
    finish_at TIME NOT NULL,    
    hall_id INT,
    film_id INT,
    FOREIGN KEY (hall_id) REFERENCES halls (id) ON DELETE CASCADE,
    FOREIGN KEY (film_id) REFERENCES films (id) ON DELETE CASCADE
);

CREATE TABLE tickets
(
    id INT PRIMARY KEY AUTO_INCREMENT,    
    seance_id INT,
    seat INT,
    price INT COMMENT "стоимость в копейках",
    status VARCHAR(10) COMMENT "доступные значения: available, paid, inactive, booked",
    FOREIGN KEY (seance_id) REFERENCES seances (id) ON DELETE CASCADE
);


INSERT INTO halls (title, seats) VALUES ('Зал 1', 200), ('Зал 2', 300), ('Зал 3', 250);

INSERT INTO genres (title) VALUES ('Боевик'), ('Комедия'), ('Мелодрама');

INSERT INTO films (title, description, year, genre_id, image_preview, teaser_preview) VALUES 
	('Когти дракона', 'Молодой ученик Тао Цзи сражается за справедливость', '1991', 1, 'http://path_to_image', 'http://path_to_teaser'),
	('Полицейские под прикрытием', 'Два полицейских работают под прикрытием', '2021', 1, 'http://path_to_image', 'http://path_to_teaser'),
	('Операция «Фортуна»', 'Команда шпионов пытается сорвать продажу супероружия', '2022', 2, 'http://path_to_image', 'http://path_to_teaser'),
	('Поющие в терновнике', 'Поющие в терновнике', '1990', 3, 'http://path_to_image', 'http://path_to_teaser');

INSERT INTO seances (date, start_at, finish_at, hall_id, film_id) VALUES
	('2023-11-27', '09:00', '10:50', 1, 1),
	('2023-11-27', '11:20', '13:10', 3, 2),
	('2023-11-27', '14:00', '17:00', 1, 3),
	('2023-11-27', '18:00', '19:50', 3, 4),
	('2023-11-27', '20:20', '22:10', 1, 2),
	('2023-11-27', '22:50', '00:00', 1, 3),
	('2023-11-27', '09:30', '11:20', 2, 1),
	('2023-11-27', '11:50', '13:40', 3, 2),
	('2023-11-27', '14:30', '17:30', 2, 3),
	('2023-11-27', '18:30', '20:20', 2, 4),
	('2023-11-27', '20:50', '22:40', 2, 2),
	('2023-11-28', '09:00', '10:50', 1, 4),
	('2023-11-28', '11:20', '13:10', 3, 2),
	('2023-11-28', '14:00', '17:00', 1, 3),
	('2023-11-28', '18:00', '19:50', 3, 1),
	('2023-11-28', '20:20', '22:10', 1, 4),
	('2023-11-28', '22:50', '00:00', 1, 3),
	('2023-11-28', '09:30', '11:20', 2, 1),
	('2023-11-28', '11:50', '13:40', 3, 2),
	('2023-11-28', '14:30', '17:30', 2, 4),
	('2023-11-28', '18:30', '20:20', 2, 1),
	('2023-11-28', '20:50', '22:40', 2, 2);


INSERT INTO tickets (seance_id, seat, price, status) VALUES
(1,1, 10000, 'paid'),
(1,2, 10000, 'inactive'),
(1,3, 10000, 'paid'),
(1,4, 10000, 'paid'),
(1,5, 10000, 'inactive'),
(1,6, 10000, 'paid'),
(1,7, 10000, 'paid'),
(1,8, 10000, 'inactive'),
(1,9, 10000, 'paid'),
(1,10, 10000, 'inactive'),

(2,1, 10000, 'paid'),
(2,2, 10000, 'inactive'),
(2,3, 10000, 'inactive'),
(2,4, 10000, 'paid'),
(2,5, 10000, 'inactive'),
(2,6, 10000, 'paid'),
(2,7, 10000, 'inactive'),
(2,8, 10000, 'paid'),
(2,9, 10000, 'paid'),
(2,10, 10000, 'paid'),

(3,1, 10000, 'paid'),
(3,2, 10000, 'inactive'),
(3,3, 10000, 'paid'),
(3,4, 10000, 'paid'),
(3,5, 10000, 'paid'),
(3,6, 10000, 'paid'),
(3,7, 10000, 'paid'),
(3,8, 10000, 'paid'),
(3,9, 10000, 'paid'),
(3,10, 10000, 'inactive'),

(5,1, 13000, 'paid'),
(5,2, 13000, 'inactive'),
(5,3, 13000, 'inactive'),
(5,4, 13000, 'paid'),
(5,5, 13000, 'inactive'),
(5,6, 13000, 'inactive'),
(5,7, 13000, 'paid'),
(5,8, 13000, 'inactive'),
(5,9, 13000, 'paid'),
(5,10, 13000, 'inactive'),

(6,1, 15000, 'paid'),
(6,2, 15000, 'paid'),
(6,3, 15000, 'paid'),
(6,4, 15000, 'paid'),
(6,5, 15000, 'paid'),
(6,6, 15000, 'paid'),
(6,7, 15000, 'paid'),
(6,8, 15000, 'paid'),
(6,9, 15000, 'paid'),
(6,10, 15000, 'inactive'),

(8,1, 10000, 'inactive'),
(8,2, 10000, 'inactive'),
(8,3, 10000, 'paid'),
(8,4, 10000, 'paid'),
(8,5, 10000, 'inactive'),
(8,6, 10000, 'paid'),
(8,7, 10000, 'inactive'),
(8,8, 10000, 'inactive'),
(8,9, 10000, 'paid'),
(8,10, 10000, 'inactive'),

(10, 1, 10000, 'inactive'),
(10, 2, 10000, 'inactive'),
(10, 3, 10000, 'paid'),
(10, 4, 10000, 'paid'),
(10, 5, 10000, 'paid'),
(10, 6, 10000, 'paid'),
(10, 7, 10000, 'paid'),
(10, 8, 10000, 'inactive'),
(10, 9, 10000, 'paid'),
(10, 10, 10000, 'inactive'),

(12, 1, 10000, 'paid'),
(12, 2, 10000, 'available'),
(12, 3, 10000, 'paid'),
(12, 4, 10000, 'paid'),
(12, 5, 10000, 'booked'),
(12, 6, 10000, 'available'),
(12, 7, 10000, 'available'),
(12, 8, 10000, 'available'),
(12, 9, 10000, 'paid'),
(12, 10, 10000, 'booked');

