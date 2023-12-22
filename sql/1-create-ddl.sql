-- public."_config" definition

-- Drop table

-- DROP TABLE public."_config";

CREATE TABLE public."_config" (
    id int4 NOT NULL,
    coefficient float4 NULL
);

-- public.demonstration definition

-- Drop table

-- DROP TABLE public.demonstration;

CREATE TABLE public.demonstration (
    id int4 NOT NULL DEFAULT nextval('_demostration_id_seq'::regclass),
    hall_id int4 NOT NULL,
    session_id int4 NOT NULL,
    film_id int4 NOT NULL,
    attendance_rate int4 NULL
);
CREATE INDEX demonstration_id_idx ON public.demonstration USING btree (id);


-- public.dict_hall definition

-- Drop table

-- DROP TABLE public.dict_hall;

CREATE TABLE public.dict_hall (
    id int4 NOT NULL,
    "name" text NOT NULL,
    seating_capacity int4 NOT NULL
);
CREATE INDEX dict_hall_id_idx ON public.dict_hall USING btree (id);
CREATE INDEX hall_id_idx ON public.dict_hall USING btree (id);


-- public.dict_session definition

-- Drop table

-- DROP TABLE public.dict_session;

CREATE TABLE public.dict_session (
    id int4 NOT NULL,
    "text" text NOT NULL
);
CREATE INDEX dict_session_hall_id_idx ON public.dict_session USING btree (id);
CREATE INDEX session_id_idx ON public.dict_session USING btree (id);


-- public.dict_status definition

-- Drop table

-- DROP TABLE public.dict_status;

CREATE TABLE public.dict_status (
    id int4 NOT NULL,
    "name" text NOT NULL
);
CREATE INDEX dict_status_hall_id_idx ON public.dict_status USING btree (id);
CREATE INDEX status_id_idx ON public.dict_status USING btree (id);


-- public.dict_ui_color definition

-- Drop table

-- DROP TABLE public.dict_ui_color;

CREATE TABLE public.dict_ui_color (
    id int4 NOT NULL,
    "name" text NOT NULL,
    CONSTRAINT "_ui_color_pkey" PRIMARY KEY (id)
);
CREATE INDEX dict_ui_color_id_idx ON public.dict_ui_color USING btree (id);


-- public.film definition

-- Drop table

-- DROP TABLE public.film;

CREATE TABLE public.film (
    id serial4 NOT NULL,
    "name" text NOT NULL,
    duration_in_minutes int4 NULL,
    price int4 NULL
);


-- public."location" definition

-- Drop table

-- DROP TABLE public."location";

CREATE TABLE public."location" (
    id int4 NOT NULL,
    "name" text NULL,
    floor int4 NOT NULL DEFAULT 1,
    "row" int4 NOT NULL,
    number_in_row int4 NOT NULL
);

-- public.seating_position definition

-- Drop table

-- DROP TABLE public.seating_position;

CREATE TABLE public.seating_position (
    id int4 NOT NULL,
    "name" text NULL,
    hall_id int4 NOT NULL,
    seat_place int4 NOT NULL,
    attendance_rate int4 NULL,
    location_id int4 NULL
);
CREATE INDEX seating_position_id_idx ON public.seating_position USING btree (id);

-- public.ticket definition

-- Drop table

-- DROP TABLE public.ticket;

CREATE TABLE public.ticket (
    id serial4 NOT NULL,
    demonstration_id int4 NOT NULL,
    status_id int4 NOT NULL,
    price int4 NOT NULL,
    position_id int4 NULL,
    showen_date date NULL,
    purchasen_date timestamptz NULL
);
