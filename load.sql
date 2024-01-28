-- Наполнение таблицы films
INSERT INTO films (name)
VALUES ('Film1'),
       ('Film2'),
       ('Film3');

-- Наполнение таблицы halls
INSERT INTO halls (name, capacity)
VALUES ('Hall1', 100),
       ('Hall2', 150),
       ('Hall3', 200);

-- Наполнение таблицы places
INSERT INTO places (place_number, row, hall_id)
VALUES (1, 1, 1),
       (2, 1, 1),
       (1, 2, 1),
       (1, 1, 2),
       (2, 1, 2),
       (1, 2, 2),
       (1, 1, 3),
       (2, 1, 3),
       (1, 2, 3);

-- Наполнение таблицы seances
INSERT INTO seances (hall_id, film_id, start, end)
VALUES (1, 1, '2022-01-01 10:00:00', '2022-01-01 12:00:00'),
       (2, 2, '2022-01-02 10:00:00', '2022-01-02 12:00:00'),
       (3, 3, '2022-01-03 10:00:00', '2022-01-03 12:00:00');

-- Наполнение таблицы tickets
INSERT INTO tickets (seance_id, place_id, price)
VALUES (1, 1, 10),
       (1, 2, 10),
       (2, 4, 12),
       (2, 5, 12),
       (3, 7, 15),
       (3, 8, 15);

-- Наполнение таблицы peoples
INSERT INTO peoples (name, phone, email)
VALUES ('Person1', '1234567890', 'person1@example.com'),
       ('Person2', '9876543210', 'person2@example.com');

-- Наполнение таблицы orders
INSERT INTO orders (user_id, ticket_id)
VALUES (1, 1),
       (1, 2),
       (2, 4),
       (2, 5),
       (2, 6);