INSERT INTO halls("id", "name")
VALUES (1, 'Красный зал'),
       (2, 'Желтый зал'),
       (3, 'Желтый зал'),
       (4, 'Зеленый зал');

INSERT INTO seats("hall_id", "row_number", "place_number")
VALUES
    (1, 1, 1),
    (1, 1, 2),
    (1, 1, 3),
    (1, 1, 4),
    (1, 2, 1),
    (1, 2, 2),
    (1, 2, 3),
    (1, 2, 4),
    (1, 3, 1),
    (1, 3, 2),
    (1, 3, 3),
    (1, 3, 4),
    (1, 4, 1),
    (1, 4, 2),
    (1, 4, 3),
    (1, 4, 4),

    (2, 1, 1),
    (2, 1, 2),
    (2, 1, 3),
    (2, 1, 4),
    (2, 2, 1),
    (2, 2, 2),
    (2, 2, 3),
    (2, 2, 4),
    (2, 3, 1),
    (2, 3, 2),
    (2, 3, 3),
    (2, 3, 4),
    (2, 4, 1),
    (2, 4, 2),
    (2, 4, 3),
    (2, 4, 4),

    (3, 1, 1),
    (3, 1, 2),
    (3, 1, 3),
    (3, 1, 4),
    (3, 2, 1),
    (3, 2, 2),
    (3, 2, 3),
    (3, 2, 4),
    (3, 3, 1),
    (3, 3, 2),
    (3, 3, 3),
    (3, 3, 4),
    (3, 4, 1),
    (3, 4, 2),
    (3, 4, 3),
    (3, 4, 4),

    (4, 1, 1),
    (4, 1, 2),
    (4, 1, 3),
    (4, 1, 4),
    (4, 2, 1),
    (4, 2, 2),
    (4, 2, 3),
    (4, 2, 4),
    (4, 3, 1),
    (4, 3, 2),
    (4, 3, 3),
    (4, 3, 4),
    (4, 4, 1),
    (4, 4, 2),
    (4, 4, 3),
    (4, 4, 4);

INSERT INTO genres(id, name) VALUES (1, 'Драма');
INSERT INTO genres(id, name) VALUES (2, 'Криминал');
INSERT INTO genres(id, name) VALUES (3, 'Ужас');
INSERT INTO genres(id, name) VALUES (4, 'Триллер');

INSERT INTO films(id, name, description, kp_rating, duration, release_date, cover_id) VALUES (1, 'Славные парни', null, 7.5, 120, '2000-01-01', null);
INSERT INTO films(id, name, description, kp_rating, duration, release_date, cover_id) VALUES (2, 'Ганибал', null, 7.5, 100, '2002-01-01', null);
INSERT INTO films(id, name, description, kp_rating, duration, release_date, cover_id) VALUES (3, 'Чужие', null, 8, 130, '1998-01-01', null);

INSERT INTO films_genres(film_id, genre_id) VALUES (1, 1);
INSERT INTO films_genres(film_id, genre_id) VALUES (1, 2);
INSERT INTO films_genres(film_id, genre_id) VALUES (2, 3);
INSERT INTO films_genres(film_id, genre_id) VALUES (2, 4);
INSERT INTO films_genres(film_id, genre_id) VALUES (3, 2);

INSERT INTO sessions(id, date, during_time, film_id, hall_id)
VALUES
    (1, '2000-03-25', '[2000-03-25 23:30:00, 2000-03-26 00:30:00]', 1, 1),
    (2, '2000-03-25', '[2000-03-25 00:30:00, 2000-03-25 01:30:00]', 1, 1),
    (3, '2000-03-25', '[2000-03-25 01:00:00, 2000-03-25 02:00:00]', 2, 2),
    (4, '2000-03-26', '[2000-03-26 10:00:00, 2000-03-26 11:00:00]', 2, 1);

INSERT INTO users(id, name, last_name, password, email, avatar) VALUES (1, 'Vyacheslav', 'Shevchenko', '123456', 'myemail1@vyacheslav.kz', null);
INSERT INTO users(id, name, last_name, password, email, avatar) VALUES (2, 'Vyacheslav', 'Shevchenko', '123456', 'myemail2@vyacheslav.kz', null);
INSERT INTO users(id, name, last_name, password, email, avatar) VALUES (3, 'Vyacheslav', 'Shevchenko', '123456', 'myemail3@vyacheslav.kz', null);
INSERT INTO users(id, name, last_name, password, email, avatar) VALUES (4, 'Vyacheslav', 'Shevchenko', '123456', 'myemail4@vyacheslav.kz', null);

INSERT INTO tickets(id, session_id, seat_id, customer_id, sale_price) VALUES
    (1, 1, 1, 1, 2000),
    (2, 1, 2, 2, 500),
    (3, 1, 3, 3, 1000),
    (4, 2, 17, 1, 2000),
    (5, 2, 18, 2, 500),
    (6, 2, 19, 3, 500),
    (7, 2, 20, 4, 500),
    (8, 4, 20, 4, 1800);

INSERT INTO discounts_types(id, name) VALUES (1, 'fix_price');
INSERT INTO discounts_types(id, name) VALUES (2, 'percent');

INSERT INTO discounts(id, name, discount_type_id,  value) VALUES (1, 'Детские билеты', 1, 1000);
INSERT INTO discounts(id, name, discount_type_id, value) VALUES (2, 'Студенческие билеты', 2, 50);
