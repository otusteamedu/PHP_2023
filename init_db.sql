INSERT
	INTO
	halls (name,
	number_seats) 
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

INSERT
	INTO
	countries (name) 
SELECT
	random_string(10)
FROM
	generate_series(1,
	10000);

insert  into genders (title) values
    ('муж.'),
    ('жен.');

INSERT
	INTO
	job_titles (name,
	salary) 
SELECT
	random_string(10),
	random_between(3000, 5000)
FROM
	generate_series(1,
	10000);

INSERT
	INTO
	Employees (job_title_id,
	gender_id,
	name,
	birthday) 
select
	random_between(1, 10000),	
	random_between(1, 2),
	random_string(10),
	random_date_between('1950-01-01',
	'2005-01-01')
FROM
	generate_series(1,
	10000);

INSERT
	INTO
	producers (name) 
SELECT
	random_string(10)
FROM
	generate_series(1,
	10000);

INSERT INTO movies (producer_id, title, duration, age_rating, user_rating, critic_rating) 
SELECT
random_between(1, 10000),
	random_string(10),
	random_between(90, 240),
	random_between(0, 21),
	random_between(1, 5),
	random_between(1, 5)
FROM
	generate_series(1,
	10000);


INSERT
	INTO
	seances (hall_id,
	movie_id,
	start_time,
	end_time,
	base_price) 
SELECT
	random_between(1,
	10000),
	random_between(1,
	10000),
	random_date_between('2024-01-01 00:00', '2024-03-01 23:59'),
	random_date_between('2024-01-01 00:00', '2024-03-01 23:59'),
	random_between(200, 400)
FROM
	generate_series(1, 10000);



INSERT
	INTO
	employees_seances  (seance_id, employee_id) 
SELECT
	random_between(1, 10000),
	random_between(1, 10000)
FROM
	generate_series(1,
	10000);

INSERT
	INTO
	movies_countries  (movie_id, contry_id) 
SELECT
	random_between(1, 10000),
	random_between(1, 10000)
FROM
	generate_series(1,
	10000);

INSERT
	INTO
	movies_genres  (movies_id, genres_id) 
SELECT
	random_between(1, 10000),
	random_between(1, 10000)
FROM
	generate_series(1,
	10000);

INSERT INTO places (hall_id, number_places, number_row, price_modifier) 
SELECT
	random_between(1, 10000),
	random_between(1, 30),
	random_between(1, 30),
	(random() + 1)
FROM
	generate_series(1,
	1000000);
	
INSERT
	INTO
	Viewers (name,
	birthday,
	discount) 
select
	random_between(1, 10000),	
	random_date_between('1950-01-01',
	'2005-01-01'),
	random() 
	
FROM
	generate_series(1,
	10000);

INSERT
	INTO
	tickets (viewer_id,
	place_id,
	seance_id,
	price,
	payment_flag,
	purchased_date) 
SELECT
	random_between(1,
	10000),
	random_between(1,
	1000000),
	random_between(1,
	10000),
	random_between(200, 400),
	(random() > 0.5),
	random_date_between('2024-01-01 00:00', '2024-03-01 23:59')
FROM
	generate_series(1, 1000000);

