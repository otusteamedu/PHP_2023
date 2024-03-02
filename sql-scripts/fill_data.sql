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

INSERT INTO "cinema" (name) VALUES
    ('Зал 1'),
    ('Зал 2'),
    ('Зал 3'),
    ('Зал 4'),
    ('Зал 5');

INSERT INTO "movie" (title, year) VALUES
     ('Терминатор', 1997),
     ('Робокоп', 1992),
     ('Хищник', 1999),
     ('Волк с Уолл стрит', 2017),
     ('Автостопом по галактике', 2005);

INSERT INTO "session_time" (time) VALUES
     ('10:00'),
     ('12:00'),
     ('17:00'),
     ('21:00');

INSERT INTO "seat" (row, col) VALUES
     (1, 1),
     (1, 2),
     (1, 3),
     (1, 4),
     (1, 5),
     (2, 1),
     (2, 2),
     (2, 3),
     (2, 4),
     (2, 5),
     (3, 1),
     (3, 2),
     (3, 3),
     (3, 4),
     (3, 5);


INSERT INTO "ticket" (id, user_id, cinema_id, movie_id, session_time_id, seat_id, date, price, vip, paid) VALUES
    (
        generate_series(1, 100),
        floor(random() * 10 + 1)::int,
        floor(random() * 5 + 1)::int,
        floor(random() * 5 + 1)::int,
        floor(random() * 4 + 1)::int,
        floor(random() * 15 + 1)::int,
        '2024-01-15',
        500 + (floor(random() * 5 + 1)::int) * 100,
        random() > 0.5,
        random() > 0.5
    );