CREATE TABLE halls
(
    hall_id  SERIAL PRIMARY KEY,
    name VARCHAR(50),
    number_seats INT
);


CREATE TABLE viewers
(
    viewer_id SERIAL PRIMARY KEY,
    name VARCHAR(50),
    birthday DATE,
    discount INT
);

CREATE TABLE producers
(
    producer_id SERIAL PRIMARY KEY,
    name VARCHAR(50)
);

CREATE TABLE genders
(
    gender_id SERIAL PRIMARY KEY,
    title VARCHAR(50)
);

CREATE TABLE job_titles
(
    job_title_id SERIAL PRIMARY KEY,
    name VARCHAR(50),
    salary NUMERIC (10, 2)
);


CREATE TABLE genres
(
    genre_id SERIAL PRIMARY KEY,
    title VARCHAR(50)
);

CREATE TABLE places
(
    place_id SERIAL PRIMARY KEY,
    hall_id INT,
    number_places INT,
    number_row INT,
    price_modifier NUMERIC(4, 2),
    FOREIGN KEY (hall_id) REFERENCES halls (hall_id)
);

CREATE TABLE movies
(
    movie_id SERIAL PRIMARY KEY,
    producer_id INT,
    title VARCHAR(255),
    duration INT,
    age_rating INT,
    user_rating NUMERIC(4, 2),
    critic_rating NUMERIC(4, 2),
    FOREIGN KEY (producer_id) REFERENCES PRODUCERS (producer_id)
);

CREATE TABLE movies_genres 
(
	movies_id int REFERENCES movies (movie_id) ON UPDATE CASCADE ON DELETE cascade,
	genres_id int REFERENCES genres (genre_id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE countries
(
    country_id SERIAL PRIMARY KEY,
    name VARCHAR(50)
);


CREATE TABLE movies_countries 
(
	movie_id int REFERENCES movies (movie_id) ON UPDATE CASCADE ON DELETE cascade,
	contry_id int REFERENCES countries (country_id) ON UPDATE CASCADE ON DELETE CASCADE
);


CREATE TABLE employees
(
    employee_id SERIAL PRIMARY KEY,
    job_title_id INT, 
    gender_id INT,
    name VARCHAR(255),
    birthday DATE,
    FOREIGN KEY (job_title_id) REFERENCES job_titles (job_title_id),
    FOREIGN KEY (gender_id) REFERENCES genders (gender_id)
);


CREATE TABLE seances
(
    seance_id SERIAL PRIMARY KEY,
    hall_id INT, 
    movie_id INT,
    start_time TIMESTAMP,
    end_time TIMESTAMP,
    base_price NUMERIC(10, 2),
    FOREIGN KEY (hall_id) REFERENCES halls (hall_id),
    FOREIGN KEY (movie_id) REFERENCES movies (movie_id)
);

CREATE TABLE employees_seances
(
	seance_id int REFERENCES seances (seance_id) ON UPDATE CASCADE ON DELETE cascade,
	employee_id int REFERENCES employees (employee_id) ON UPDATE CASCADE ON DELETE CASCADE
);


CREATE TABLE tickets
(
    ticket_id SERIAL PRIMARY KEY,
    viewer_id INT,
    place_id INT,
    seance_id INT,
    price NUMERIC(10, 2),
    payment_flag BOOL, 
    purchased_date DATE,

    FOREIGN KEY (viewer_id) REFERENCES viewers (viewer_id),
    FOREIGN KEY (place_id) REFERENCES places (place_id),
    FOREIGN KEY (seance_id) REFERENCES seances (seance_id)
);