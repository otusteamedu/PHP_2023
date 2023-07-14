

CREATE TABLE films (
    id serial NOT NULL PRIMARY KEY,
    name varchar(255) NOT NULL,
    duration time NOT NULL,
    cost decimal(20,6) NOT NULL
);


CREATE TABLE attr_types (
    id serial NOT NULL PRIMARY KEY,
    name varchar(255) NOT NULL,
	value_column_name varchar(255) NOT NULL
);

CREATE TABLE attributes (
    id serial NOT NULL PRIMARY KEY,
    name varchar(255) NOT NULL,
	attr_type_id integer NOT NULL,
	FOREIGN KEY (attr_type_id) REFERENCES attr_types (id)
);



CREATE TABLE values (
    id serial NOT NULL PRIMARY KEY,
    attr_id integer NOT NULL,
    film_id integer NOT NULL,
	value_text text,
	value_bool boolean,
	value_date date,
	value_date_tz timestamptz,
    value_int integer,
    value_double double precision,
	FOREIGN KEY (attr_id) REFERENCES attributes (id),
	FOREIGN KEY (film_id) REFERENCES films (id)
);

