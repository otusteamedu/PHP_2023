INSERT INTO films (name, film_description, duration, price, age_rating)
VALUES ('Avengers: Endgame', 'After the devastating events of Avengers: Infinity War, the universe is in ruins. With the help of remaining allies, the Avengers assemble once more in order to reverse Thanos\' actions and restore balance to the universe.', 181, 10.99, 12);

INSERT INTO films (name, film_description, duration, price, age_rating)
VALUES ('Joker', 'In Gotham City, mentally-troubled comedian Arthur Fleck embarks on a downward spiral of social revolution and bloody crime. This path brings him face-to-face with his alter-ego: the Joker.', 122, 8.99, 16);

INSERT INTO films (name, film_description, duration, price, age_rating)
VALUES ('The Lion King', 'After the murder of his father, a young lion prince flees his kingdom only to learn the true meaning of responsibility and bravery.', 118, 9.99, 0);

INSERT INTO zones (name, coefficient)
VALUES ('Normal', 1.00);

INSERT INTO zones (name, coefficient)
VALUES ('VIP', 1.50);

INSERT INTO session_types (name, coefficient)
VALUES ('2D', 1.00);

INSERT INTO session_types (name, coefficient)
VALUES ('3D', 1.50);

INSERT INTO hall_types (name, coefficient)
VALUES ('Regular', 1.00);

INSERT INTO hall_types (name, coefficient)
VALUES ('IMAX', 2.00);

INSERT INTO viewers (full_name, age)
VALUES ('John Doe', 25);

INSERT INTO viewers (full_name, age)
VALUES ('Jane Smith', 30);

INSERT INTO halls (name, coefficient)
VALUES ('Hall 1', 1.00);

INSERT INTO halls (name, coefficient)
VALUES ('Hall 2', 1.00);

INSERT INTO hall_types_halls (hall_id, hall_type_id)
VALUES (1, 1);

INSERT INTO hall_types_halls (hall_id, hall_type_id)
VALUES (2, 2);

INSERT INTO sessions (session_type, hall_id, film_id, time_start, time_end)
VALUES (1, 1, 1, '2021-01-01 18:00:00', '2021-01-01 20:00:00');

INSERT INTO sessions (session_type, hall_id, film_id, time_start, time_end)
VALUES (2, 2, 2, '2021-01-01 20:30:00', '2021-01-01 22:30:00');

INSERT INTO seats (seat_num, row_num, zone_id, hall_id)
VALUES (1, 1, 1, 1);

INSERT INTO seats (seat_num, row_num, zone_id, hall_id)
VALUES (2, 1, 1, 1);

INSERT INTO seats (seat_num, row_num, zone_id, hall_id)
VALUES (1, 1, 2, 2);

INSERT INTO seats (seat_num, row_num, zone_id, hall_id)
VALUES (2, 1, 2, 2);

INSERT INTO tickets (seat_id, viewer_id, session_id)
VALUES (1, 1, 1);

INSERT INTO tickets (seat_id, viewer_id, session_id)
VALUES (2, 2, 2);


INSERT INTO attribute_types (name)
VALUES
    ('Рецензия'),
    ('Обзор'),
    ('Комментарий для сотрудников'),
    ('Рейтинг'),
    ('Возрастной ценз'),
    ('Бюджет'),
    ('Сборы'),
    ('Спеццена'),
    ('Служебные даты'),
    ('Важные даты'),
    ('Премия');

INSERT INTO attributes (name, attribute_type_id)
VALUES
    ('Рецензия журнала Миллениум', 1),
    ('Обзор от Баженова', 2),
    ('Премьера в РФ', 10),
    ('Премия ника', 12),
    ('Золотой глобус', 12),
    ('Мировые сборы', 7),
    ('Сборы в США', 7),
    ('Новогодняя цена', 8),
    ('Цена в честь важного инфоповода', 8),
    ('Начало новогодних показов', 9),
    ('Важный инфоповод', 9),
    ('Завершение новогодних показов', 9),
    ('Возрастной рейтинг для особого региона', 5),
    ('Премия оскар', 12);

INSERT INTO attribute_values (film_id, attribute_id, text_val, bool_val, datetime_val, int_val, numeric_val, price_val)
VALUES
    (1, 1, 'Great movie, must see!', NULL, NULL, NULL, NULL, NULL),
    (2, 2, 'One of the best performances I have ever seen', NULL, NULL, NULL, NULL, NULL),
    (1, 3, NULL, NULL, '2021-01-01 00:00:00', NULL, NULL, NULL),
    (1, 4, NULL, TRUE, NULL, NULL, NULL, NULL),
    (2, 5, NULL, FALSE, NULL, NULL, NULL, NULL),
    (1, 6, NULL, NULL, NULL, NULL, 2797800564, NULL),
    (1, 7, NULL, NULL, NULL, NULL, 858373000, NULL),
    (1, 8, NULL, NULL, NULL, NULL, NULL, 1000.00),
    (2, 9, NULL, NULL, NULL, NULL, NULL, 800.00),
    (1, 10, NULL, NULL, '2023-12-31 00:00:00', NULL, NULL, NULL),
    (1, 11, NULL, NULL, '2023-12-31 00:00:00', NULL, NULL, NULL),
    (3, 12, NULL, NULL, '2024-01-31 00:00:00', NULL, NULL, NULL),
    (3, 13, NULL, NULL, NULL, 16, NULL, NULL);