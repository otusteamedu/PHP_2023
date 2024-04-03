create table if not exists cinema
(
	id serial not null
		constraint cinema_pk
			primary key,
	name varchar not null,
	halls integer default 1,
	address varchar,
	status integer default 1
);

alter table cinema owner to alisa;

create table if not exists hall
(
	id serial not null
		constraint hall_pk
			primary key,
	cinema_id integer not null
		constraint hall_cinema_id_fk
			references cinema
				on update cascade on delete cascade,
	status integer default 1
);

alter table hall owner to alisa;

create unique index if not exists hall_id_uindex
	on hall (id);

create table if not exists session
(
	id serial not null
		constraint session_pk
			primary key,
	hall_id integer not null,
	film_id integer not null,
	beginning_time integer not null
);

alter table session owner to alisa;

create unique index if not exists session_id_uindex
	on session (id);

create table if not exists film
(
	id serial not null
		constraint film_pk
			primary key,
	name varchar not null,
	duration integer not null
);

alter table film owner to alisa;

create unique index if not exists film_id_uindex
	on film (id);

create table if not exists ticket
(
	id serial not null
		constraint ticket_pk
			primary key,
	session_id integer not null,
	row integer not null,
	place integer not null,
	status integer default 1 not null,
	price integer not null
);

alter table ticket owner to alisa;

create unique index if not exists ticket_id_uindex
	on ticket (id);

create table if not exists places_in_hall
(
	hall_id integer not null,
	row integer not null,
	place_count integer not null
);

alter table places_in_hall owner to alisa;

