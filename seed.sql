INSERT INTO halls (name, description)
VALUES ('Первый зал', 'Лофт зал'),
       ('Второй зал', 'Лофт по меньше'),
       ('Третий зал', 'VIPka');

INSERT INTO seats_in_halls (hall_id, seats, row)
VALUES ((SELECT id FROM halls WHERE name = 'Первый зал'), 1, 1),
       ((SELECT id FROM halls WHERE name = 'Второй зал'), 1, 2),
       ((SELECT id FROM halls WHERE name = 'Третий зал'), 2, 14);

INSERT INTO movies (name, duration)
VALUES ('Зов ктулху', 120),
       ('Хребты безумия', 180),
       ('Цвет из иных миров', 200);

INSERT INTO showtime (movie_id, hall_id, start_time, end_time)
VALUES ((SELECT id FROM movies WHERE name = 'Зов ктулху'), (SELECT id FROM halls WHERE name = 'Первый зал'),
        '2023-12-01 22:00:00', '2023-12-02 00:00:00'),
       ((SELECT id FROM movies WHERE name = 'Хребты безумия'), (SELECT id FROM halls WHERE name = 'Второй зал'),
        '2023-12-01 22:30:00', '2023-12-02 01:00:00'),
       ((SELECT id FROM movies WHERE name = 'Цвет из иных миров'), (SELECT id FROM halls WHERE name = 'Третий зал'),
        '2023-12-01 23:00:00', '2023-12-02 02:30:00');

INSERT INTO customers (name, phone)
VALUES ('Жрец', '89899988621'),
       ('Фанатик', '78962562224'),
       ('Культист', '863222995435');

INSERT INTO tickets (price, showtime_id, customer_id, seat_in_hall_id)
VALUES (150, (SELECT id FROM showtime WHERE id = 1), (SELECT id FROM customers WHERE name = 'Жрец'),
        (SELECT id FROM seats_in_halls WHERE id = 1)),
       (200, (SELECT id FROM showtime WHERE id = 2), (SELECT id FROM customers WHERE name = 'Фанатик'),
        (SELECT id FROM seats_in_halls WHERE id = 2)),
       (250, (SELECT id FROM showtime WHERE id = 3), (SELECT id FROM customers WHERE name = 'Культист'),
        (SELECT id FROM seats_in_halls WHERE id = 3));