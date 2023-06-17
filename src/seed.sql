INSERT INTO hall (name, capacity, description)
VALUES
    ('Зал 1', 250, 'Основной зал'),
    ('Зал 2', 100, 'Малый зал'),
    ('Зал 3', 50, 'VIP зал');

INSERT INTO hall_row (seats, hall_id)
VALUES
    (30, (SELECT id FROM hall WHERE name = 'Зал 1')),
    (12, (SELECT id FROM hall WHERE name = 'Зал 2')),
    (10, (SELECT id FROM hall WHERE name = 'Зал 3'));

INSERT INTO movie (name, director, genre, duration)
VALUES
    ('Капитан фантастик', 'Мэтт Росс', 'Драма', 118),
    ('Подземелья и драконы', 'Джон Фрэнсис', 'Фэнтези', 134),
    ('Таксист', 'Чан Хун', 'История', 137);

INSERT INTO showtime (hall_id, movie_id, start_time, end_time, price)
VALUES
    ((SELECT id FROM hall WHERE name = 'Зал 1'), (SELECT id FROM movie WHERE name = 'Капитан фантастик'), '2023-06-15 18:00:00', '2023-06-15 20:00:00', 280),
    ((SELECT id FROM hall WHERE name = 'Зал 2'), (SELECT id FROM movie WHERE name = 'Подземелья и драконы'), '2023-06-15 20:30:00', '2023-06-15 22:00:00', 150),
    ((SELECT id FROM hall WHERE name = 'Зал 3'), (SELECT id FROM movie WHERE name = 'Таксист'), '2023-06-15 19:30:00', '2023-06-15 22:30:00', 460);

INSERT INTO customer (first_name, last_name, email, phone)
VALUES
    ('Алексей', 'Ташматов', 'alex@gmail.com', '1234567890'),
    ('Константин', 'Константинопольский', 'konst@mail.com', '9876543210'),
    ('Елена', 'Премудрая', 'elena@yandex.com', '5555555555');

INSERT INTO ticket (showtime_id, customer_id, row, seat, price)
VALUES
    ((SELECT id FROM showtime WHERE price = 280), (SELECT id FROM customer WHERE first_name = 'Алексей'), 7, 15, 250),
    ((SELECT id FROM showtime WHERE price = 280), (SELECT id FROM customer WHERE first_name = 'Константин'), 8, 10, 240),
    ((SELECT id FROM showtime WHERE price = 460), (SELECT id FROM customer WHERE first_name = 'Елена'), 1, 5, 460);
