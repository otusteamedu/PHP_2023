
INSERT INTO halls (number, capacity) VALUES (1, 30), (2, 35), (3, 40);

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

INSERT INTO tickets (price, place, payed, session_id, customer_id) VALUES
    (250, 10, 1, 1, 1),
    (250, 11, 1, 2, 1),
    (250, 12, 1, 3, 1),
    (250, 13, 1, 4, 1),
    (250, 14, 1, 1, 2),
    (250, 15, 1, 2, 2),
    (250, 16, 1, 3, 2),
    (250, 17, 1, 4, 2),
    (250, 18, 1, 1, 3),
    (250, 19, 1, 2, 3),
    (250, 20, 1, 3, 3),
    (250, 21, 1, 4, 3);

SELECT f.id, f.name, SUM(t.price) AS sum FROM films AS f JOIN sessions AS s on f.id = s.film_id JOIN tickets AS t on s.id = t.session_id GROUP BY f.id ORDER BY sum DESC LIMIT 1;
