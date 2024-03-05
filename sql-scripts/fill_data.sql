INSERT INTO "user" (email, password_hash, name) VALUES
   ('test1@mail.ru', 'password_hash1', 'Иванов Иван Иванович'),
   ('test2@mail.ru', 'password_hash2', 'Петров Петр Петрович'),
   ('test3@mail.ru', 'password_hash3', 'Сидоров Сидор Сидорович'),
   ('test4@mail.ru', 'password_hash4', 'Агеев Сергей Сергеевич'),
   ('test5@mail.ru', 'password_hash5', 'Белов Александр Александрович'),
   ('test6@mail.ru', 'password_hash6', 'Одинцов Станислав Владимирович'),
   ('test7@mail.ru', 'password_hash7', 'Дорохина Ирина Викторовна'),
   ('test8@mail.ru', 'password_hash8', 'Ткачева Татьяна Александровна'),
   ('test9@mail.ru', 'password_hash9', 'Бойко Наталья Викторовна'),
   ('test10@mail.ru', 'password_hash10', 'Агаркова Анна Николаевна');

INSERT INTO "movie" (title, year) VALUES
     ('Терминатор', 1997),
     ('Робокоп', 1992),
     ('Хищник', 1999);

INSERT INTO "cinema_hall" (name)
VALUES
    ('Зал1'),
    ('Зал2'),
    ('Зал3');


INSERT INTO "seat"
(row, col, vip, cinema_hall_id)
VALUES
    (1, 1, random() > 0.5, 1),
    (1, 2, random() > 0.5, 1),
    (1, 3, random() > 0.5, 1),
    (1, 4, random() > 0.5, 1),
    (1, 5, random() > 0.5, 1),
    (2, 1, random() > 0.5, 1),
    (2, 2, random() > 0.5, 1),
    (2, 3, random() > 0.5, 1),
    (2, 4, random() > 0.5, 1),
    (2, 5, random() > 0.5, 1),
    (3, 1, random() > 0.5, 1),
    (3, 2, random() > 0.5, 1),
    (3, 3, random() > 0.5, 1),
    (3, 4, random() > 0.5, 1),
    (3, 5, random() > 0.5, 1);

INSERT INTO "seat"
    (row, col, vip, cinema_hall_id)
VALUES
    (1, 1, random() > 0.5, 2),
    (1, 2, random() > 0.5, 2),
    (1, 3, random() > 0.5, 2),
    (1, 4, random() > 0.5, 2),
    (1, 5, random() > 0.5, 2),
    (2, 1, random() > 0.5, 2),
    (2, 2, random() > 0.5, 2),
    (2, 3, random() > 0.5, 2),
    (2, 4, random() > 0.5, 2),
    (2, 5, random() > 0.5, 2),
    (3, 1, random() > 0.5, 2),
    (3, 2, random() > 0.5, 2),
    (3, 3, random() > 0.5, 2),
    (3, 4, random() > 0.5, 2),
    (3, 5, random() > 0.5, 2);

INSERT INTO "seat"
(row, col, vip, cinema_hall_id)
VALUES
    (1, 1, random() > 0.5, 3),
    (1, 2, random() > 0.5, 3),
    (1, 3, random() > 0.5, 3),
    (1, 4, random() > 0.5, 3),
    (1, 5, random() > 0.5, 3),
    (2, 1, random() > 0.5, 3),
    (2, 2, random() > 0.5, 3),
    (2, 3, random() > 0.5, 3),
    (2, 4, random() > 0.5, 3),
    (2, 5, random() > 0.5, 3),
    (3, 1, random() > 0.5, 3),
    (3, 2, random() > 0.5, 3),
    (3, 3, random() > 0.5, 3),
    (3, 4, random() > 0.5, 3),
    (3, 5, random() > 0.5, 3);

INSERT INTO "session" (movie_id, cinema_hall_id, "date")
VALUES
    (1, 1, '2024-01-15 09:00'),
    (2, 1, '2024-01-15 12:00'),
    (3, 1, '2024-01-15 15:00');

INSERT INTO "session" (movie_id, cinema_hall_id, "date")
VALUES
    (1, 2, '2024-01-15 09:00'),
    (2, 2, '2024-01-15 12:00'),
    (3, 2, '2024-01-15 15:00');

INSERT INTO "session" (movie_id, cinema_hall_id, "date")
VALUES
    (1, 3, '2024-01-15 09:00'),
    (2, 3, '2024-01-15 12:00'),
    (3, 3, '2024-01-15 15:00');

INSERT INTO "ticket_price" (id, session_id, seat_id, price)
VALUES (
            generate_series(1, 15),
            1,
            generate_series(1, 15),
            500 + (floor(random() * 5 + 1)::int) * 100
        );

INSERT INTO "ticket_price" (id, session_id, seat_id, price)
VALUES (
           generate_series(16, 30),
           2,
           generate_series(1, 15),
           500 + (floor(random() * 5 + 1)::int) * 100
       );

INSERT INTO "ticket_price" (id, session_id, seat_id, price)
VALUES (
           generate_series(31, 45),
           3,
           generate_series(1, 15),
           500 + (floor(random() * 5 + 1)::int) * 100
       );

INSERT INTO "ticket_price" (id, session_id, seat_id, price)
VALUES (
           generate_series(46, 60),
           4,
           generate_series(16, 30),
           500 + (floor(random() * 5 + 1)::int) * 100
       );

INSERT INTO "ticket_price" (id, session_id, seat_id, price)
VALUES (
           generate_series(61, 75),
           5,
           generate_series(16, 30),
           500 + (floor(random() * 5 + 1)::int) * 100
       );

INSERT INTO "ticket_price" (id, session_id, seat_id, price)
VALUES (
           generate_series(76, 90),
           6,
           generate_series(16, 30),
           500 + (floor(random() * 5 + 1)::int) * 100
       );
INSERT INTO "ticket_price" (id, session_id, seat_id, price)
VALUES (
           generate_series(91, 105),
           7,
           generate_series(31, 45),
           500 + (floor(random() * 5 + 1)::int) * 100
       );

INSERT INTO "ticket_price" (id, session_id, seat_id, price)
VALUES (
           generate_series(106, 120),
           8,
           generate_series(31, 45),
           500 + (floor(random() * 5 + 1)::int) * 100
       );

INSERT INTO "ticket_price" (id, session_id, seat_id, price)
VALUES (
           generate_series(121, 135),
           9,
           generate_series(31, 45),
           500 + (floor(random() * 5 + 1)::int) * 100
       );


INSERT INTO "ticket" (id, session_id, seat_id, ticket_price_id)
VALUES (generate_series(1, 15),
        1,
        generate_series(1, 15),
        generate_series(1, 15));

INSERT INTO "ticket" (id, session_id, seat_id, ticket_price_id)
VALUES (generate_series(16, 30),
        2,
        generate_series(1, 15),
        generate_series(16, 30));

INSERT INTO "ticket" (id, session_id, seat_id, ticket_price_id)
VALUES (generate_series(31, 45),
        3,
        generate_series(1, 15),
        generate_series(31, 45));

INSERT INTO "ticket" (id, session_id, seat_id, ticket_price_id)
VALUES (generate_series(46, 60),
        4,
        generate_series(16, 30),
        generate_series(46, 60));

INSERT INTO "ticket" (id, session_id, seat_id, ticket_price_id)
VALUES (generate_series(61, 75),
        5,
        generate_series(16, 30),
        generate_series(61, 75));

INSERT INTO "ticket" (id, session_id, seat_id, ticket_price_id)
VALUES (generate_series(76, 90),
        6,
        generate_series(16, 30),
        generate_series(76, 90));

INSERT INTO "ticket" (id, session_id, seat_id, ticket_price_id)
VALUES (generate_series(91, 105),
        7,
        generate_series(31, 45),
        generate_series(91, 105));

INSERT INTO "ticket" (id, session_id, seat_id, ticket_price_id)
VALUES (generate_series(106, 120),
        8,
        generate_series(31, 45),
        generate_series(106, 120));

INSERT INTO "ticket" (id, session_id, seat_id, ticket_price_id)
VALUES (generate_series(121, 135),
        9,
        generate_series(31, 45),
        generate_series(121, 135));

INSERT INTO "order" (id, ticket_id, user_id, is_paid, date)
VALUES (
        generate_series(1, 100),
        (floor(random() * 135 + 1)::int),
        (floor(random() * 10 + 1)::int),
        random() > 0.5,
        '2024-01-01 00:00:00'
        );