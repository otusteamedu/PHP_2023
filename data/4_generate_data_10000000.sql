--film
INSERT INTO film(id, name, description)
SELECT step,
       'Фильм ' || random_string(random_between(15, 50)),
       random_string(random_between(30, 255))
FROM generate_series(10001, 10000000) as step;


--hall
INSERT INTO hall(id, name, description)
SELECT step,
       '№' || step::text,
       'Зал №' || step::text
FROM generate_series(10001, 10000000) as step;


--client
INSERT INTO client (id, surname, name, patronymic, email, phone, created_at)
SELECT step,
       random_string(random_between(4, 30)),
       random_string(random_between(4, 30)),
       random_string(random_between(4, 30)),
       random_string(random_between(101, 120)) || '@gmail.com',
       '+7' || step::text || random_between(1, 9)::text,
       timestamp '2024-01-01 08:00:00' +
       random_between(1, 90) * (timestamp '2024-01-01 20:00:00' - timestamp '2024-01-01 10:00:00')
FROM generate_series(10001, 10000000) as step;


--place
INSERT INTO place(id, row, number, hall_id, markup)
SELECT step,
       random_between(1, 25),
       random_between(1, 50),
       random_between(1, 10000000),
       random_between(0, 30)
FROM generate_series(10001, 10000000) as step;


--seance
INSERT INTO seance (id, film_id, hall_id, date)
SELECT step,
       random_between(1, 10000000),
       random_between(1, 10000000),
       timestamp '2024-01-01 08:00:00' +
       random_between(1, 90) * (timestamp '2024-01-01 20:00:00' - timestamp '2024-01-01 10:00:00')
FROM generate_series(10001, 13000000) as step;


--price
INSERT INTO price (id, seance_id, place_id, price)
SELECT step,
       random_between(1, 1000000),
       random_between(1, 1000000),
       random_between(200, 500)
FROM generate_series(10001, 10000000) as step;


--ticket
INSERT INTO ticket (id, date, client_id, price)
SELECT step,
       timestamp '2024-01-01 08:00:00' +
       random_between(1, 90) * (timestamp '2024-01-01 20:00:00' - timestamp '2024-01-01 10:00:00'),
       random_between(1, 100000),
       step
FROM generate_series(10001, 10000000) as step;
