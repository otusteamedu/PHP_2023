--create database cinema;

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

insert
	into
	genres (title)
values ('Мультфильм'),
('Комедия'),
('Боевик'),
('Триллер'),
('Драма');

create table public.films
(
    id serial primary key,
    title VARCHAR(255) not null,
    description VARCHAR(1000) not null,
    image_preview VARCHAR(255) not null,
    teaser_preview VARCHAR(255) not null
);

INSERT INTO films (title, description, image_preview, teaser_preview) VALUES 
	('Три богатыря и Пуп Земли', 'По сказкам мы знаем, что было давным-давно, но что было еще давным-давнее? Трем богатырям предстоит узнать ответ на этот вопрос, хоть они его и не задавали. Тут такое началось, что игогошеньки! Горыныч вдруг находит динозаврика, а Алеша Попович с Князем и конем Юлием буквально проваливаются сквозь землю. Теперь надо срочно понять, как вернуть их назад в будущее. А главное, узнать, кто или что такое загадочный Пуп земли.', 'http://path_to_image', 'http://path_to_teaser'),
	('Бременские музыканты', 'Они снова в сборе — самая легендарная группа бродячих артистов! Трубадур и его друзья-самозванцы — Пес, Кошка, Осел и самовлюбленный Петух — объединились, чтобы совершить подвиг! Бродячие музыканты во главе с новым лидером снова сплотятся, чтобы вернуть смех и радость на мрачные улицы Бремена. И прежде всего они должны рассмешить дочь Короля, но встреча с Принцессой грозит опасным приключением! Против Трубадура и его друзей — коварные враги, интриги и ловушки, но за любовь надо сражаться. А тут еще Принцесса сбежала из дворца! В одном клубке — преступные схемы Разбойников, интриги Сыщика, капризы и тайны королевской семейки, но веселые музыканты с неутомимым Трубадуром заставят всех плясать под свою дудку! На что готовы Бременские музыканты ради подвига?', 'http://path_to_image', 'http://path_to_teaser'),
	('Холоп 2', 'Главный герой продолжения комедийного блокбастера — Гриша, бывший мажор, побывавший в роли холопа из позапрошлого века, изменившей его к лучшему. После путешествия в «прошлое» он чутко реагирует на любую несправедливость и, конечно же, не может пройти мимо беспредела, который творит наглая и избалованная Катя. Ничего удивительного, что вскоре мажорка обнаруживает себя в другом времени и в другом социальном статусе…', 'http://path_to_image', 'http://path_to_teaser'),
	('Последний наемник', 'Легендарный наемный убийца Финбар решает, что он уже не так хорош и ему пора отойти от дел. Но однажды в город, где он залег на дно, наведывается банда и начинает беспредел. Финбару ничего не остается, как встать на сторону правосудия и снова взяться за оружие. И на этот раз он рискует не только собой, но и всеми, кто ему дорог.', 'http://path_to_image', 'http://path_to_teaser'),
	('Феррари', 'Об автомобилях Ferrari мечтают миллионы, а имеют единицы. Это символ роскошной жизни, известный во всем мире. Но блестящий фасад скрывает трагическую историю основателя компании Энцо Феррари. Семейные проблемы, финансовый кризис, ужасные аварии и даже гнев Ватикана — все это в свое время преодолел гениальный конструктор и бизнесмен, чтобы вписать свое имя в историю автопрома навсегда.', 'http://path_to_image', 'http://path_to_teaser'),
	('Фильм 1', 'DEsc', 'http://path_to_image', 'http://path_to_teaser'),
	('Фильм 2', 'DEsc', 'http://path_to_image', 'http://path_to_teaser'),
	('Фильм 3', 'DEsc', 'http://path_to_image', 'http://path_to_teaser'),
	('Фильм 4', 'DEsc', 'http://path_to_image', 'http://path_to_teaser');

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
);

INSERT INTO film_genres (film_id, genre_id) VALUES (1,1), (1,2);
INSERT INTO film_genres (film_id, genre_id) VALUES (2,2);
INSERT INTO film_genres (film_id, genre_id) VALUES (3,2);
INSERT INTO film_genres (film_id, genre_id) VALUES (4,3), (4,4);
INSERT INTO film_genres (film_id, genre_id) VALUES (5,5);


create table public.attribute_type
(
	id serial primary key,
	type varchar(20) not null
);

insert into attribute_type (type) values ('text'), ('date'), ('boolean'), ('integer');


create table public.attributes
(
	id serial primary key,
	title varchar(255) not null,
	attribute_type_id int,
	foreign key (attribute_type_id) references attribute_type (id) on
delete
	cascade
	);
	
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
	);
	
insert into film_attribute (film_id, attribute_id, text_value, date_value, boolean_value, integer_value) values 
(1, 6, null, null, null, 87),
(1, 5, null, '2024-01-01', null, null),
(2, 6, null, null, null, 115),
(2, 5, null, '2023-12-20', null, null),
(3, 6, null, null, null, 119),
(3, 5, null, '2024-01-01', null, null),
(4, 6, null, null, null, 105),
(4, 5, null, '2023-12-15', null, null),
(4, 6, null, null, null, 105),
(4, 5, null, '2023-12-20', null, null);


create table public.halls
(
    id serial primary key,
	title VARCHAR(255) not null,
	rows integer not null,
	seats INTEGER not null
);

INSERT INTO halls (title, rows, seats) VALUES 
	('Зал 1', 11, 15), 
	('Зал 2', 11, 15), 
	('Зал 3', 12, 15), 
	('Зал 4', 12, 15), 
	('Зал 5', 10, 15), 
	('Зал 6', 11, 15), 
	('Зал 7', 11, 15), 
	('Зал 8', 11, 15);

create table public.seances
(
    id serial primary key,
    start_at Timestamp not null,
    finish_at Timestamp not null,    
    hall_id INT,
    film_id INT,
    foreign key (hall_id) references halls (id) on
delete
	cascade,
	foreign key (film_id) references films (id) on
	delete
		cascade
);

CREATE or replace PROCEDURE insert_data(film_id integer, hall_id integer, start_date date, days integer, hours text[])
LANGUAGE plpgsql
AS $$
declare 
	i integer := 0;
	date date;
	start_at timestamp;
	finish_at timestamp;
	h text;
	duration integer;
begin
		
	i := 0;
	for i in 0..days loop
		date := (select start_date::DATE + i);

		FOREACH h IN ARRAY hours
		  loop
		    start_at := (date || ' ' || h);
			finish_at := (select start_at + interval '90 minutes' );
			INSERT INTO seances(start_at, finish_at, hall_id, film_id) VALUES (start_at, finish_at, hall_id, film_id);
		  END LOOP;
		
	end loop;
end;
$$;

call insert_data(1, 1, '2024-01-07', 30, array['10:40', '12:10', '16:35', '19:30', '22:30']::text[]);
call insert_data(2, 2, '2023-12-20', 30, array['10:40', '12:50', '15:10', '17:30', '19:50', '23:30']::text[]);
call insert_data(2, 3, '2024-01-07', 30, array['11:40', '14:00', '16:20', '18:40', '21:00']::text[]);
call insert_data(3, 4, '2024-01-07', 30, array['10:15', '12:45', '15:15', '17:45', '20:15', '23:30']::text[]);
call insert_data(3, 5, '2024-01-07', 30, array['11:30', '14:00', '16:30', '19:00', '21:30']::text[]);
call insert_data(4, 6, '2023-12-15', 30, array['09:15', '11:45', '13:50', '17:00', '19:10', '22:00']::text[]);
call insert_data(5, 7, '2023-12-20', 30, array['09:15', '11:45', '13:50', '17:00', '19:10', '22:00']::text[]);
call insert_data(6, 8, '2024-01-02', 30, array['09:15', '11:45', '13:50', '17:00', '19:10', '22:00']::text[]);

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

CREATE or replace PROCEDURE insert_tickets()
LANGUAGE plpgsql
AS $$
declare 
	seance seances;
	hall halls;
	row integer;
	seat integer;
	price integer := 250;
	statuses text[] := array['paid', 'booked', 'inactive'];
	index integer;
	status text;
begin		
	FOR seance IN 
  		SELECT * FROM seances
   	loop   		
   		select * into hall from halls where id = seance.hall_id;
   		for row in 1..hall.rows loop
	   		for seat in 1..hall.seats loop
	   			index := (SELECT round(random() * 2 + 1));
	   			status := statuses[index];
	   			
	   			INSERT INTO tickets(seance_id, row, seat, price, status) VALUES (seance.id, row,seat, price, status);
	   		end loop;
   		end loop;
   		

   	END LOOP;

end;
$$;

call insert_tickets();


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
where a.id in (8,9);

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
