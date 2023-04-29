INSERT INTO movies (id, name, description, duration)
SELECT nextval('movies_id_seq'),
    random_string(25),
    random_string(300),
    random() * 100 + 50
FROM generate_series(1, 100000);

INSERT INTO movie_genres (movie_id, genre_id)
SELECT
    gs.id,
    random_number(1, 9)
FROM generate_series(1, 100000) as gs(id);

INSERT INTO movie_attribute_values (id, movie_id, attribute_id, value_text)
SELECT nextval('movie_attribute_values_id_seq'),
       gs.id,
       1,
       random_string(200)
FROM generate_series(1, 100000) as gs(id);

INSERT INTO movie_attribute_values (id, movie_id, attribute_id, value_text)
SELECT nextval('movie_attribute_values_id_seq'),
       gs.id,
       2,
       random_string(200)
FROM generate_series(1, 100000) as gs(id);

INSERT INTO movie_attribute_values (id, movie_id, attribute_id, value_boolean)
SELECT nextval('movie_attribute_values_id_seq'),
       gs.id,
       3,
       random() < 0.5
FROM generate_series(1, 100000) as gs(id);

INSERT INTO movie_attribute_values (id, movie_id, attribute_id, value_boolean)
SELECT nextval('movie_attribute_values_id_seq'),
       gs.id,
       4,
       random() < 0.5
FROM generate_series(1, 100000) as gs(id);

INSERT INTO movie_attribute_values (id, movie_id, attribute_id, value_date)
SELECT nextval('movie_attribute_values_id_seq'),
       gs.id,
       5,
       random_date('2023-01-01 00:00:00', '2023-05-01 00:00:00')
FROM generate_series(1, 100000) as gs(id);

INSERT INTO movie_attribute_values (id, movie_id, attribute_id, value_date)
SELECT nextval('movie_attribute_values_id_seq'),
       gs.id,
       6,
       random_date('2023-01-01 00:00:00', '2023-05-01 00:00:00')
FROM generate_series(1, 100000) as gs(id);

INSERT INTO movie_attribute_values (id, movie_id, attribute_id, value_date)
SELECT nextval('movie_attribute_values_id_seq'),
       gs.id,
       7,
       random_date('2023-01-01 00:00:00', '2023-05-01 00:00:00')
FROM generate_series(1, 100000) as gs(id);

INSERT INTO movie_attribute_values (id, movie_id, attribute_id, value_date)
SELECT nextval('movie_attribute_values_id_seq'),
       gs.id,
       8,
       random_date('2023-01-01 00:00:00', '2023-05-01 00:00:00')
FROM generate_series(1, 100000) as gs(id);

INSERT INTO schedules (id, datetime, movie_id, cinema_hall_id)
SELECT nextval('schedules_id_seq'),
       random_date('2023-01-01 00:00:00', '2023-05-01 00:00:00'),
       gs.id,
       random_number(1, 3)
FROM generate_series(1, 100000) as gs(id);

INSERT INTO schedule_prices (schedule_id, place_type_id, price)
SELECT s.id, 1, 350
FROM schedules s
ORDER BY id
OFFSET 0;

INSERT INTO schedule_prices (schedule_id, place_type_id, price)
SELECT s.id, 2, 500
FROM schedules s
ORDER BY id
OFFSET 0;

SELECT count(sell_tickets(gs.id))
FROM generate_series(1, 100000) as gs(id);
