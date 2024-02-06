insert  into viewers (name, birthday, discount) values 
    ('Петя', '01.01.2000', 10),
    ('Маша', '02.02.1990', 15),
    ('Авдотья', '03.03.1950', 50);

insert into halls (name, number_seats) values
    ('Малый', 50),
    ('Средний', 100),
    ('Большой', 150);
insert  into producers (name) values
    ('Джордж Лукас'),
    ('Стивен Спилберг'),
    ('Джеймс Кемерон');
insert  into genres (title) values 
    ('Фантастика'),
    ('Боевик'),
    ('Комедия'),
    ('Ужасы');
insert  into genders (title) values
    ('муж.'),
    ('жен.');
insert into job_titles (name, salary) values 
    ('Администратор', 100000.00),
    ('Уборщица', 20000.00),
    ('Билетер', 30000.00);
insert  into employees (job_title_id, gender_id, name, birthday) values
    (1, 2, 'Маша', '01.01.1980'),
    (1, 1, 'Петя', '01.03.1985'),
    (2, 2, 'Оля', '05.05.1990'),
    (2, 2, 'Катя', '06.06.1970'),
    (3, 2, 'Лиза', '07.07.1978'),
    (3, 1, 'Игорь', '08.08.1998');
insert  into places (hall_id, number_places, number_row, price_modifier) values
    (1, 1, 1, 1.0),
    (1, 2, 2, 0.9),
    (1, 3, 3, 1.2),
    (2, 1, 1, 1.0),
    (2, 2, 2, 0.9),
    (2, 3, 3, 1.2),
    (3, 1, 1, 1.0),
    (3, 2, 2, 0.9),
    (3, 3, 3, 1.2);
insert into movies (producer_id, title, duration, country, age_rating, user_rating, critic_rating) values
    (1, 'Фильм 1', 150, 'USA', 17, 8.0, 8.2),
    (2, 'Movie 2', 90, 'USSR', 6, 9.9, 9.9),
    (2, 'Movie 3', 120, 'China', 21, 8.2, 8.4),
    (3, 'Movie 4', 86, 'Germany', 17, 6.2, 6.1),
    (3, 'Movie 43', 92, 'Danemark', 6, 7.0, 7.0);
insert  into  seances (hall_id, movie_id, start_time, end_time, base_price) values
    (1, 1, '2024-01-01 10:00', '2024-01-01 13:00', 300),
    (2, 2, '2024-01-01 10:00', '2024-01-01 13:00', 300),
    (3, 3, '2024-01-01 10:00', '2024-01-01 13:00', 300),
    (3, 2, '2024-01-02 10:00', '2024-01-02 13:00', 300),
    (3, 1, '2024-01-03 10:00', '2024-01-03 13:00', 300);

insert  into movies_genres (movies_id, genres_id) values
    (1, 1),
    (1, 2),
    (2, 1),
    (2, 2),
    (3, 1),
    (1, 3),
    (3, 2);
insert  into employees_seances (seance_id, employee_id) values
    (1, 1),
    (1, 2),
    (2, 1),
    (3, 1),
    (1, 3),
    (3, 3);

insert  into  tickets (viewer_id, place_id, seance_id, price, payment_flag) values 
    (1, 1, 1, 300.0, false),
    (2, 2, 1, 300.0, false),
    (3, 3, 1, 300.0, false),
    (2, 4, 2, 300.0, false),
    (2, 5, 3, 300.0, false),
    (1, 6, 3, 300.0, false);