INSERT INTO halls (name, description)
VALUES ('Зал 1', 'Основной зал'),
       ('Зал 2', 'Малый зал'),
       ('Зал 3', 'VIP зал');

INSERT INTO seats_in_halls (hall_id, seats, row)
VALUES ((SELECT id FROM halls WHERE name = 'Зал 1'), 1, 1),
       ((SELECT id FROM halls WHERE name = 'Зал 2'), 1, 2),
       ((SELECT id FROM halls WHERE name = 'Зал 3'), 2, 14);

INSERT INTO movies (name, duration)
VALUES ('фильм1', 60),
       ('фильм2', 90),
       ('фильм3', 120);

INSERT INTO showtime (movie_id, hall_id, start_time, end_time)
VALUES ((SELECT id FROM movies WHERE name = 'фильм1'), (SELECT id FROM halls WHERE name = 'Зал 1'),
        '2023-06-15 19:00:00', '2023-06-15 20:00:00'),
       ((SELECT id FROM movies WHERE name = 'фильм2'), (SELECT id FROM halls WHERE name = 'Зал 2'),
        '2023-06-15 19:30:00', '2023-06-15 21:00:00'),
       ((SELECT id FROM movies WHERE name = 'фильм3'), (SELECT id FROM halls WHERE name = 'Зал 3'),
        '2023-06-15 20:30:00', '2023-06-15 22:30:00');

INSERT INTO customers (name, phone)
VALUES ('customer1', '1234567890'),
       ('customer2', '9876543210'),
       ('customer3', '2222222222');

INSERT INTO tickets (price, showtime_id, customer_id, seat_in_hall_id)
VALUES (150, (SELECT id FROM showtime WHERE id = 1), (SELECT id FROM customers WHERE name = 'customer1'),
        (SELECT id FROM seats_in_halls WHERE id = 1)),
       (200, (SELECT id FROM showtime WHERE id = 2), (SELECT id FROM customers WHERE name = 'customer2'),
        (SELECT id FROM seats_in_halls WHERE id = 2)),
       (250, (SELECT id FROM showtime WHERE id = 3), (SELECT id FROM customers WHERE name = 'customer3'),
        (SELECT id FROM seats_in_halls WHERE id = 3));

INSERT INTO attributes_type (name)
VALUES ('string'),
       ('text'),
       ('image'),
       ('bool'),
       ('datetime'),
       ('date'),
       ('integer'),
       ('float');

INSERT INTO attributes (name, attribute_type_id)
VALUES ('рецензии', (SELECT id FROM attributes_type WHERE name = 'text')),
       ('премия оскар', (SELECT id FROM attributes_type WHERE name = 'bool')),
       ('премия ника', (SELECT id FROM attributes_type WHERE name = 'bool')),
       ('мировая премьера', (SELECT id FROM attributes_type WHERE name = 'date')),
       ('премьера в РФ', (SELECT id FROM attributes_type WHERE name = 'date')),
       ('начала продажи билетов', (SELECT id FROM attributes_type WHERE name = 'date')),
       ('запуск рекламы на TВ', (SELECT id FROM attributes_type WHERE name = 'datetime')),
       ('бюджет', (SELECT id FROM attributes_type WHERE name = 'float')),
       ('возраст', (SELECT id FROM attributes_type WHERE name = 'integer'));

INSERT INTO attributes_values (movie_id, attribute_id, val_text, val_date, val_timestamp, val_float, val_bool, val_int)
VALUES (1, (SELECT id FROM attributes WHERE name = 'рецензии'), 'Отличный фильм...', NULL, NULL, NULL, NULL, NULL),
       (1, (SELECT id FROM attributes WHERE name = 'премия оскар'), NULL, NULL, NULL, NULL, true, NULL),
       (1, (SELECT id FROM attributes WHERE name = 'премия ника'), NULL, NULL, NULL, NULL, true, NULL),
       (1, (SELECT id FROM attributes WHERE name = 'мировая премьера'), NULL, '2023-10-18', NULL, NULL, NULL, NULL),
       (1, (SELECT id FROM attributes WHERE name = 'премьера в РФ'), NULL, '2023-10-22', NULL, NULL, NULL, NULL),
       (1, (SELECT id FROM attributes WHERE name = 'начала продажи билетов'), NULL, NULL, '2023-10-23 12:00:00', NULL,
        NULL, NULL),
       (1, (SELECT id FROM attributes WHERE name = 'запуск рекламы на TВ'), NULL, NULL, '2023-10-22 10:00:00', NULL,
        NULL, NULL),
       (1, (SELECT id FROM attributes WHERE name = 'бюджет'), NULL, NULL, NULL, '165000.00', NULL, NULL),
       (1, (SELECT id FROM attributes WHERE name = 'возраст'), NULL, NULL, NULL, NULL, NULL, 18),

       (2, (SELECT id FROM attributes WHERE name = 'рецензии'), 'Фильм так себе...', NULL, NULL, NULL, NULL, NULL),
       (2, (SELECT id FROM attributes WHERE name = 'премия оскар'), NULL, NULL, NULL, NULL, true, NULL),
       (2, (SELECT id FROM attributes WHERE name = 'премия ника'), NULL, NULL, NULL, NULL, false, NULL),
       (2, (SELECT id FROM attributes WHERE name = 'мировая премьера'), NULL, '2023-10-25', NULL, NULL, NULL, NULL),
       (2, (SELECT id FROM attributes WHERE name = 'премьера в РФ'), NULL, '2023-10-29', NULL, NULL, NULL, NULL),
       (2, (SELECT id FROM attributes WHERE name = 'бюджет'), NULL, NULL, NULL, '16500.00', NULL, NULL),

       (3, (SELECT id FROM attributes WHERE name = 'премия оскар'), NULL, NULL, NULL, NULL, false, NULL),
       (3, (SELECT id FROM attributes WHERE name = 'премия ника'), NULL, NULL, NULL, NULL, true, NULL),
       (3, (SELECT id FROM attributes WHERE name = 'начала продажи билетов'), NULL, NULL, '2023-10-24 12:00:00', NULL,
        NULL, NULL),
       (3, (SELECT id FROM attributes WHERE name = 'запуск рекламы на TВ'), NULL, NULL, '2023-10-23 10:00:00', NULL,
        NULL, NULL),
       (3, (SELECT id FROM attributes WHERE name = 'возраст'), NULL, NULL, NULL, NULL, NULL, 14);
