
INSERT INTO halls (number, capacity) VALUES (1, 30), (2, 35), (3, 40);

INSERT INTO `rows` (number, hall_id) VALUES
     (1, 1), (2, 1), (3, 1), (4, 1), (5, 1), (6, 1),
     (1, 2), (2, 2), (3, 2), (4, 2), (5, 2), (6, 2),
     (1, 3), (2, 3), (3, 3), (4, 3), (5, 3), (6, 3);

INSERT INTO prices (amount) VALUES (200), (250), (300);

INSERT INTO places (number, price_id, row_id) VALUES
     (1, 1, 1), (2, 1, 1), (3, 1, 1), (4, 1, 1), (5, 1, 1), (6, 1, 1),
     (7, 2, 2), (8, 2, 2), (9, 2, 2), (10, 2, 2), (11, 2, 2), (12, 2, 2),
     (13, 3, 3), (14, 3, 3), (15, 3, 3), (16, 3, 3), (17, 3, 3), (18, 3, 3),
     (1, 1, 4), (2, 1, 4), (3, 1, 4), (4, 1, 4), (5, 1, 4), (6, 1, 4),
     (7, 2, 5), (8, 2, 5), (9, 2, 5), (10, 2, 5), (11, 2, 5), (12, 2, 5),
     (13, 3, 6), (14, 3, 6), (15, 3, 6), (16, 3, 6), (17, 3, 6), (18, 3, 6);

INSERT INTO films (name, release_date, country_production, duration) VALUES
    ('Avatar', '2022-08-02', 'USA', 120),
    ('Robocop', '2021-07-03', 'USA', 129),
    ('Aliens', '2020-06-04', 'USA', 134);

INSERT INTO customers (user_name, email) VALUES
     ('ivan', 'ivan@test.ru'),
     ('gleb', 'gleb@test.ru'),
     ('stepan', 'stepan@test.ru');

INSERT INTO sessions (date_start, date_end, hall_id, film_id) VALUES
     ('2023-03-01 08:00:00', '2023-03-01 10:00:00', 1, 1),
     ('2023-03-01 10:00:00', '2023-03-01 12:00:00', 1, 2),
     ('2023-03-01 12:00:00', '2023-03-01 14:00:00', 1, 3),
     ('2023-03-01 14:00:00', '2023-03-01 16:00:00', 1, 1);

INSERT INTO tickets (total_price, payed, row_id, place_id, session_id, customer_id) VALUES
    (270, 1, 1, 1, 1, 1),
    (270, 1, 1, 2, 1, 1),
    (270, 1, 1, 3, 1, 1),
    (270, 1, 1, 4, 1, 1),
    (270, 1, 1, 5, 1, 2),
    (270, 1, 1, 6, 1, 2),
    (270, 1, 2, 7, 2, 2),
    (270, 1, 2, 8, 2, 2),
    (270, 1, 2, 9, 3, 3),
    (270, 1, 2, 10, 3, 3),
    (270, 1, 2, 11, 3, 3),
    (270, 1, 2, 12, 3, 3);

SELECT f.id, f.name, SUM(t.total_price) AS sum FROM films AS f JOIN sessions AS s on f.id = s.film_id JOIN tickets AS t on s.id = t.session_id WHERE t.payed=1 GROUP BY f.id ORDER BY sum DESC LIMIT 1;
