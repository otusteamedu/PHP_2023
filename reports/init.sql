CREATE TABLE public."_config" (
    id serial4 NOT NULL,
    coefficient float4 NULL
);

CREATE TABLE public.demonstration (
    id serial4 NOT NULL,
    hall_id int4 NOT NULL,
    session_id int4 NOT NULL,
    film_id int4 NOT NULL,
    attendance_rate int4 NULL
);

CREATE TABLE public.dict_hall (
    id serial4 NOT NULL,
    "name" text NOT NULL,
    seating_capacity int4 NOT NULL
);

CREATE TABLE public.dict_session (
    id serial4 NOT NULL,
    "text" text NOT NULL
);

CREATE TABLE public.dict_status (
    id serial4 NOT NULL,
    "name" text NOT NULL
);

CREATE TABLE public.dict_ui_color (
    id serial4 NOT NULL,
    "name" text NOT NULL
);

CREATE TABLE public.film (
    id serial4 NOT NULL,
    "name" text NOT NULL,
    duration_in_minutes int4 NULL,
    price int4 NULL
);

CREATE TABLE public."location" (
    id serial4 NOT NULL,
    "name" text NULL,
    floor int4 NOT NULL DEFAULT 1,
    "row" int4 NOT NULL,
    number_in_row int4 NOT NULL
);

CREATE TABLE public.seating_position (
    id serial4 NOT NULL,
    "name" text NULL,
    hall_id int4 NOT NULL,
    seat_place int4 NOT NULL,
    attendance_rate int4 NULL,
    location_id int4 NULL
);

CREATE TABLE public.ticket (
    id serial4 NOT NULL,
    demonstration_id int4 NOT NULL,
    status_id int4 NOT NULL,
    price int4 NOT NULL,
    position_id int4 NULL,
    showen_date date NULL,
    purchasen_date timestamptz NULL
);
