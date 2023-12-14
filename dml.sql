INSERT INTO Halls (id, name)
VALUES (1, 'Зал 1'),
       (2, 'Зал 2');


INSERT INTO price_seat_modificators (id, name, price)
VALUES
    (1, 'боковое', 0),
    (2, 'центральное', 50);


INSERT INTO seats (id, hall_id, price_seat_modificator_id, column, row)
VALUES
    (1, 1, 1, 1, 1),
    (2, 1, 2, 1, 2),
    (3, 2, 1, 1, 1),
    (4, 2, 2, 1, 2);


INSERT INTO movies (id, name, price)
VALUES
    (1, 'Фильм 1', 100),
    (2, 'Фильм 2', 200);



INSERT INTO price_seance_modificators (id, name, price)
VALUES
    (1, 'утро', 0),
    (2, 'день', 100),
    (3, 'вечер', 200);


INSERT INTO users (id, email)
VALUES
    (1, 'user_1@mail.ru'),
    (2, 'user_2@mail.ru'),


INSERT INTO seances (id, hall_id, movie_id, price_seance_modificator_id, date_start)
VALUES
    (1, 1, 1, 1, '2023-20-01 10:00:00'),
    (2, 2, 2, 2, '2023-20-01 22:00:00'),


INSERT INTO tickets (id, seat_id, seance_id, user_id, price)
VALUES
    (1, 1, 1, 1, 100),
    (2, 2, 1, 1, 100),
    (3, 3, 2, 2, 350),
    (4, 4, 2, 2, 350),
