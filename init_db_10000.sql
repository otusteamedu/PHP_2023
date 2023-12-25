INSERT
	INTO
	halls (title,
	capacity) 
SELECT
	random_string(10),
	random_between(100, 500)
FROM
	generate_series(1,
	10000);

INSERT
	INTO
	genres (title) 
SELECT
	random_string(10)
FROM
	generate_series(1,
	10000);
	
INSERT INTO movies (genre_id, title, duration, rating) 
SELECT
random_between(1, 10000),
	random_string(10),
	random_between(90, 240),
	random_between(1, 5)
FROM
	generate_series(1,
	10000);

INSERT
	INTO
	seances (hall_id,
	movie_id,
	base_price,
	start_date,
	start_time) 
SELECT
	random_between(1,
	10000),
	random_between(1,
	10000),
	random_between(200,
	400),
	random_date_between('2023-12-10', '2023-12-31'),
	('20:00')
FROM
	generate_series(1,
	10000);

INSERT INTO type_seats (title) VALUES
	('Обычный'),
	('VIP');

INSERT INTO seats (hall_id, type_seats_id, seat_number, number_row, price_modifier) 
SELECT
	random_between(1, 10000),
	random_between(1, 2),
	random_between(1, 200),
	random_between(1, 10),
	(random() + 1)
FROM
	generate_series(1,
	10000);

INSERT
	INTO
	tickets (seance_id,
	seat_id,
	price,
	purchased_date,
	purchased_time) 
SELECT
	random_between(1,
	10000),
	random_between(1,
	200),
	random_between(200,
	400),
	random_date_between('2023-12-10 20:00',
	'2023-12-31 22:00'),
	('10:00')
FROM
	generate_series(1,
	10000);