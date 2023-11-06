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
