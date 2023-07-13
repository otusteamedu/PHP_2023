CREATE TABLE IF NOT EXISTS cinema
(
    id serial not null,
    name varchar(50),
    primary key (id)
);
CREATE TABLE IF NOT EXISTS cinema_hall
(
    id serial not null,
    cinema_id int not null,
    name varchar(50),
    PRIMARY KEY (id)
);
CREATE TABLE IF NOT EXISTS cinema_hall_places
(
    id serial not null,
    cinema_hall_id int not null,
    row smallint not null ,
    place smallint not null ,
    PRIMARY KEY (id)
);
CREATE TABLE IF NOT EXISTS movie
(
    id serial not null,
    name varchar(150),
    primary key (id)
);
CREATE TABLE IF NOT EXISTS movie_attribute
(
    id serial not null,
    movie_attribute_type_id int not null,
    name varchar(100),
    code varchar(100),
    primary key (id)
);
CREATE TABLE IF NOT EXISTS movie_attribute_type
(
    id serial not null,
    name varchar(100) not null,
    code varchar(100) not null,
    type varchar(20) not null,
    primary key (id)
);
CREATE TABLE IF NOT EXISTS movie_attribute_value
(
    id serial not null,
    movie_id int not null,
    movie_attribute_id int not null,
    value_text text,
    value_integer int,
    value_float float,
    value_boolean smallint,
    value_date date,
    primary key (id)
);
CREATE TABLE IF NOT EXISTS session
(
    id serial not null,
    cinema_hall_id int not null,
    movie_id int not null,
    start_date timestamp,
    end_date timestamp,
    PRIMARY KEY (id)
);
CREATE TABLE IF NOT EXISTS session_place
(
    id serial not null,
    session_id int not null,
    cinema_hall_places_id int not null,
    status smallint DEFAULT 0,
    PRIMARY KEY (id)
);
CREATE TABLE IF NOT EXISTS session_movie_price
(
    id serial not null,
    movie_id int not null,
    session_id int not null,
    price float,
    PRIMARY KEY (id)
);
CREATE TABLE IF NOT EXISTS ticket
(
    id serial not null,
    session_id int not null,
    session_place_id int not null,
    price float not null,
    checkout_id int,
    primary key (id)
);
CREATE TABLE IF NOT EXISTS checkout
(
    id serial not null,
    date timestamp default NOW(),
    primary key (id)
);

-- create view view_movie_attributes as
-- SELECT m.name   as movie_name,
--        mat.type as attribute_type,
--        ma.name  as attribute_name,
--        concat(
--                COALESCE(mav.value_text, ''),
--                COALESCE(mav.value_boolean, ''),
--                COALESCE(mav.value_date, ''),
--                COALESCE(mav.value_float, ''),
--                COALESCE(mav.value_integer, '')
--            )    as attribute_value
-- FROM movie as m
--          JOIN movie_attribute_value mav on m.id = mav.movie_id
--          JOIN movie_attribute ma on mav.movie_attribute_id = ma.id
--          JOIN movie_attribute_type mat on mat.id = ma.movie_attribute_type_id;
--
-- create view view_service_dates as
-- SELECT m.name   as movie_name,
--        ma.name  as movie_attribute_name,
--        concat(
--                COALESCE(mav.value_text, ''),
--                COALESCE(mav.value_boolean, ''),
--                COALESCE(mav.value_date, ''),
--                COALESCE(mav.value_float, ''),
--                COALESCE(mav.value_integer, '')
--            ) as attribute_value
-- from movie as m
--          join movie_attribute_value mav on m.id = mav.movie_id
--          join movie_attribute ma on mav.movie_attribute_id = ma.id
--          join movie_attribute_type mat on ma.movie_attribute_type_id = mat.id
-- where mat.code = 'date_service' and (mav.value_date = CURDATE() OR mav.value_date = DATE_ADD(CURDATE(), INTERVAL 20 DAY));
--
-- /** тестовые данные */
-- insert into movie VALUES (null, 'Крепкий орешек');
-- insert into movie VALUES(null, 'Крепкий орешек 2');
-- insert into movie VALUES(null, 'Черепашки ниндзя');
--
-- insert into movie_attribute_type VALUES(null, 'Целое число', 'integer', 'integer');
-- insert into movie_attribute_type VALUES(null, 'Дробное число', 'float', 'float');
-- insert into movie_attribute_type VALUES(null, 'Да/нет', 'boolean', 'float');
-- insert into movie_attribute_type VALUES(null, 'Текст', 'text', 'date');
-- insert into movie_attribute_type VALUES(null, 'Дата', 'date', 'date');
-- insert into movie_attribute_type VALUES(null, 'Рецензии', 'review', 'text');
-- insert into movie_attribute_type VALUES(null, 'Премия', 'award', 'boolean');
-- insert into movie_attribute_type VALUES(null, 'Важная дата', 'date_important', 'date');
-- insert into movie_attribute_type VALUES(null, 'Служебная дата', 'date_service', 'date');
--
-- insert into movie_attribute values(null, 4, 'Жанр', 'genre');
-- insert into movie_attribute values(null, 1, 'Длительность', 'length');
-- insert into movie_attribute values(null, 6, 'Рецензия критиков', 'review_critic');
-- insert into movie_attribute values(null, 6, 'Отзыв неизвестной киноакадемии', 'review_unknown_academy');
-- insert into movie_attribute values(null, 7, 'Оскар', 'oskar');
-- insert into movie_attribute values(null, 7, 'Ника', 'nika');
-- insert into movie_attribute values(null, 8, 'Мировая премьера', 'world_start_date');
-- insert into movie_attribute values(null, 8, 'Старт в РФ', 'rf_start');
-- insert into movie_attribute values(null, 9, 'Дата начала продажи билетов', 'date_start_sellings');
-- insert into movie_attribute values(null, 9, 'Запуск рекламы', 'date_start_ad');
--
-- insert into movie_attribute_value (movie_id, movie_attribute_id, value_text) VALUES (1, 1, 'Боевик');
-- insert into movie_attribute_value (movie_id, movie_attribute_id, value_integer) VALUES (1, 2, 7500);
-- insert into movie_attribute_value (movie_id, movie_attribute_id, value_date) VALUES (1, 7, '2000-03-10');
-- insert into movie_attribute_value (movie_id, movie_attribute_id, value_date) VALUES (1, 8, '2000-11-10');
--
-- insert into movie_attribute_value (movie_id, movie_attribute_id, value_date) VALUES (1, 9, '2023-06-22');
-- insert into movie_attribute_value (movie_id, movie_attribute_id, value_date) VALUES (1, 9, '2023-06-23');
-- insert into movie_attribute_value (movie_id, movie_attribute_id, value_date) VALUES (1, 9, '2023-06-27');
-- insert into movie_attribute_value (movie_id, movie_attribute_id, value_date) VALUES (1, 9, '2023-06-30');
-- insert into movie_attribute_value (movie_id, movie_attribute_id, value_date) VALUES (1, 9, '2023-07-20');
-- insert into movie_attribute_value (movie_id, movie_attribute_id, value_date) VALUES (1, 9, '2023-07-12');