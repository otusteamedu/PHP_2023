create database cinema;

drop view if exists marketing_data;
drop view if exists service_data;

drop table if exists tickets;
drop table if exists seances;
drop table if exists film_attribute;
drop table if exists attributes;
drop table if exists attribute_type;
drop table if exists film_genres;
drop table if exists films;
drop table if exists genres;
drop table if exists halls;


create table public.genres
(
    id serial primary key,
    title VARCHAR(255) not null
);

INSERT INTO genres (title) VALUES ('Боевик'), ('Комедия'), ('Мелодрама'), ('Триллер');


create table public.films
(
    id serial primary key,
    title VARCHAR(255) not null,
    description VARCHAR(1000) not null,
    image_preview VARCHAR(255) not null,
    teaser_preview VARCHAR(255) not null
)

INSERT INTO films (title, description, image_preview, teaser_preview) VALUES 
	('Когти дракона', 'Молодой ученик Тао Цзи сражается за справедливость', 'http://path_to_image', 'http://path_to_teaser'),
	('Полицейские под прикрытием', 'Два полицейских работают под прикрытием',  'http://path_to_image', 'http://path_to_teaser'),
	('Операция «Фортуна»', 'Команда шпионов пытается сорвать продажу супероружия', 'http://path_to_image', 'http://path_to_teaser'),
	('Отпуск по обмену', 'Отпуск по обмену', 'http://path_to_image', 'http://path_to_teaser');


create table public.film_genres
(
    film_id int not null,
    genre_id int not null,
	foreign key (film_id) references films (id) on
delete
	cascade,
	foreign key (genre_id) references genres (id) on
	delete
		cascade
)

INSERT INTO film_genres (film_id, genre_id) VALUES (1,1), (2,1), (2,2), (3,1), (3,2), (4,3);


create table public.attribute_type
(
	id serial primary key,
	type varchar(20) not null
)

insert into attribute_type (type) values ('text'), ('date'), ('boolean'), ('integer');


create table public.attributes
(
	id serial primary key,
	title varchar(255) not null,
	attribute_type_id int,
	foreign key (attribute_type_id) references attribute_type (id) on
delete
	cascade
	)
	
insert into attributes (title, attribute_type_id) values ('Рецензия', 1), ('Отзыв', 1);
insert into attributes (title, attribute_type_id) values ('Премия Оскар', 3), ('Премия Ника', 3);
insert into attributes (title, attribute_type_id) values ('Мировая премьера', 2);
insert into attributes (title, attribute_type_id) values ('Продолжительность в минутах', 4);
insert into attributes (title, attribute_type_id) values ('Возратсные ограничения', 4);
insert into attributes (title, attribute_type_id) values ('Начало продажи билетов', 2);
insert into attributes (title, attribute_type_id) values ('Начало запуска рекламы', 2);

create table public.film_attribute
(
	film_id int not null,
	attribute_id int not null,
	text_value text,
	date_value date,
	boolean_value boolean,
	integer_value int,
	foreign key (film_id) references films (id) on
delete
	cascade,
	foreign key (attribute_id) references attributes (id) on
	delete
		cascade
	)
	
insert into film_attribute (film_id, attribute_id, text_value, date_value, boolean_value, integer_value) values 
(3, 3, null, null, true, null),
(3, 5, null, '2023-12-20', null, null),
(3, 7, null, null, null, 16),
(3, 6, null, null, null, 90);

insert into film_attribute (film_id, attribute_id, text_value, date_value, boolean_value, integer_value) values 
(1, 3, null, null, false, null),
(1, 5, null, '2023-12-24', null, null),
(1, 9, null, '2023-11-30', null, null),
(1, 8, null, '2023-12-20', null, null),
(1, 6, null, null, null, 110),
(3, 7, null, null, null, 12);

create table public.halls
(
    id serial primary key,
	title VARCHAR(255) not null,
	seats INTEGER not null
);

INSERT INTO halls (title, seats) VALUES ('Зал 1', 200), ('Зал 2', 300), ('Зал 3', 250);

create table public.seances
(
    id serial primary key,
    start_at DATE not null,
    finish_at DATE not null,    
    hall_id INT,
    film_id INT,
    foreign key (hall_id) references halls (id) on
delete
	cascade,
	foreign key (film_id) references films (id) on
	delete
		cascade
);

INSERT INTO seances (start_at, finish_at, hall_id, film_id) VALUES
	('2023-11-30 09:00', '2023-11-30 10:50', 1, 2),
	('2023-11-30 10:00', '2023-11-30 11:50', 2, 4),
	('2023-11-30 11:20', '2023-11-30 13:30', 3, 2),
	('2023-11-30 12:00', '2023-11-30 14:50', 1, 4),
	('2023-11-30 13:10', '2023-11-30 15:00', 2, 2),
	('2023-11-30 14:20', '2023-11-30 15:50', 3, 4),
	('2023-11-30 15:30', '2023-11-30 17:20', 1, 2),
	('2023-11-30 17:00', '2023-11-30 18:50', 2, 4),
	('2023-11-30 19:00', '2023-11-30 20:50', 3, 2),
	('2023-11-30 20:00', '2023-11-30 21:50', 1, 4),
	('2023-11-30 21:00', '2023-11-30 22:50', 2, 2),
	('2023-11-30 22:00', '2023-11-30 23:50', 3, 4),
	('2023-11-30 23:00', '2023-12-01 00:50', 1, 2);

create table public.tickets
(
    id serial primary key,    
    seance_id INT,
    row INT,
    seat INT,
    price decimal(12,2),
    status VARCHAR(10),
    foreign key (seance_id) references seances (id) on
delete
	cascade
);

comment on
column public.tickets.status is 'доступные значения: available, paid, inactive, booked';

INSERT INTO tickets (seance_id, row, seat, price, status) VALUES
(1,1, 1, 100.00, 'paid'),
(1,2, 1, 100.00, 'inactive'),
(1,3, 1, 100.00, 'paid'),
(1,4, 1, 100.00, 'paid'),
(1,5, 2, 100.00, 'inactive'),
(1,6, 2, 100.00, 'paid'),
(1,7, 2, 100.00, 'paid'),
(1,8, 4, 150.00, 'inactive'),
(1,9, 5, 150.00, 'paid'),
(1,10, 10, 160.00, 'inactive'),
(2,1, 4, 100.00, 'paid'),
(2,2, 4, 100.00, 'inactive'),
(2,3, 6, 100.00, 'inactive'),
(2,4, 10, 100.00, 'paid'),
(2,5, 3, 100.00, 'inactive'),
(2,6, 5, 100.00, 'paid'),
(2,7, 4, 100.00, 'inactive'),
(2,8, 10, 150.00, 'paid'),
(2,9, 7, 150.00, 'paid'),
(2,10, 8, 160.00, 'paid'),
(3,5,5, 100.00, 'paid'),
(3,5,6, 100.00, 'inactive'),
(3,5,7, 100.00, 'paid'),
(3,5,8, 100.00, 'paid'),
(3,6,5, 100.00, 'paid'),
(3,6,6, 100.00, 'paid'),
(3,5,9, 100.00, 'paid'),
(3,7,4, 150.00, 'paid'),
(3,5,1, 100.00, 'paid'),
(3,9,3, 150.00, 'inactive'),
(5,4,5, 130.00, 'paid'),
(5,4,6, 130.00, 'inactive'),
(5,4,7, 130.00, 'inactive'),
(5,4,8, 130.00, 'paid'),
(5,5,4, 130.00, 'inactive'),
(5,5,6, 130.00, 'inactive'),
(5,7,6, 170.00, 'paid'),
(5,8,8, 170.00, 'inactive'),
(5,8,9, 170.00, 'paid'),
(5,10,5, 190.00, 'inactive'),
(6,5,1, 130.00, 'paid'),
(6,5,2, 130.00, 'paid'),
(6,5,3, 130.00, 'paid'),
(6,5,4, 130.00, 'paid'),
(6,5,5, 130.00, 'paid'),
(6,5,6, 130.00, 'paid'),
(6,5,7, 130.00, 'paid'),
(6,5,8, 130.00, 'paid'),
(6,5,9, 130.00, 'paid'),
(6,5,10, 130.00, 'inactive'),
(8,5,5, 130.00, 'inactive'),
(8,5,6, 130.00, 'inactive'),
(8,5,7, 130.00, 'paid'),
(8,6,4, 130.00, 'paid'),
(8,6,5, 130.00, 'inactive'),
(8,6,6, 130.00, 'paid'),
(8,7,5, 150.00, 'inactive'),
(8,8,5, 170.00, 'inactive'),
(8,8,5, 170.00, 'paid'),
(8,8,10, 170.00, 'inactive'),
(10, 4,1, 130.00, 'inactive'),
(10, 4,2, 130.00, 'inactive'),
(10, 5,3, 130.00, 'paid'),
(10, 6,4, 150.00, 'paid'),
(10, 6,5, 150.00, 'paid'),
(10, 7,6, 150.00, 'paid'),
(10, 8,7, 170.00, 'paid'),
(10, 8,8, 170.00, 'inactive'),
(10, 8,9, 170.00, 'paid'),
(10, 8,10, 170.00, 'inactive'),
(12, 6,1, 160.00, 'paid'),
(12, 6,2, 160.00, 'available'),
(12, 6,3, 160.00, 'paid'),
(12, 7,4, 160.00, 'paid'),
(12, 7,5, 160.00, 'booked'),
(12, 7,6, 160.00, 'available'),
(12, 7,7, 160.00, 'available'),
(12, 8,8, 190.00, 'available'),
(12, 8,9, 190.00, 'paid'),
(12, 8,10, 190.00, 'booked'),
(13, 4, 6, 160.00, 'paid'),
(13, 7,5, 160.00, 'available'),
(13, 5,3, 160.00, 'paid'),
(13, 5,4, 160.00, 'paid'),
(13, 9,5, 190.00, 'booked'),
(13, 9,6, 190.00, 'available'),
(13, 9,7, 190.00, 'available'),
(13, 10,6, 2010.00, 'available'),
(13, 10,7, 210.00, 'paid'),
(13, 10,8, 210.00, 'booked');

CREATE VIEW service_data AS
select
	f.title as film,
	current_date ,
	(case when fa.date_value = current_date then a.title end) as today,
	(case when fa.date_value = (current_date + interval '20' day ) then a.title end) as after_20_days
from
	films f
left join film_attribute fa on
	f.id = fa.film_id
left join "attributes" a on
	a.id = fa.attribute_id
where a.id in (8,9)

CREATE VIEW marketing_data AS
select
	f.title as film,
	a.title as attribute,
	coalesce (
		fa.date_value::varchar,
		fa.integer_value::varchar,
		fa.boolean_value::varchar,
		fa.text_value
	) as value	
from
	films f
left join film_attribute fa on
	f.id = fa.film_id
left join "attributes" a on
	a.id = fa.attribute_id 
left join attribute_type att on att.id = a.attribute_type_id ;
