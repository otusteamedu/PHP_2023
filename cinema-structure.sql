--
-- PostgreSQL database dump
--

-- Dumped from database version 16.1 (Debian 16.1-1.pgdg120+1)
-- Dumped by pg_dump version 16.1 (Debian 16.1-1.pgdg120+1)



CREATE TABLE public.films (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    length time without time zone DEFAULT '00:00:00'::time without time zone NOT NULL
);


ALTER TABLE public.films OWNER TO postgres;


ALTER TABLE public.films ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.films_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);



CREATE TABLE public.halls (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    count_seats integer DEFAULT 0 NOT NULL,
    price_ratio real DEFAULT 1 NOT NULL
);


ALTER TABLE public.halls OWNER TO postgres;


ALTER TABLE public.halls ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.halls_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);



CREATE TABLE public.halls_seat_schema (
    seat_num integer DEFAULT 0 NOT NULL,
    hall_id integer DEFAULT 0 NOT NULL,
    price_ratio real NOT NULL,
    "row" smallint DEFAULT 0 NOT NULL,
    col smallint DEFAULT 0 NOT NULL
);


ALTER TABLE public.halls_seat_schema OWNER TO postgres;


CREATE TABLE public.seance_tikets (
    id integer NOT NULL,
    seance_id integer DEFAULT 0 NOT NULL,
    user_id integer DEFAULT 0 NOT NULL,
    seat_num integer DEFAULT 0 NOT NULL,
    price numeric(10,2) DEFAULT 0 NOT NULL
);


ALTER TABLE public.seance_tikets OWNER TO postgres;


ALTER TABLE public.seance_tikets ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.seance_tikets_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);



CREATE TABLE public.seances (
    id integer NOT NULL,
    film_id integer NOT NULL,
    date date DEFAULT '1999-01-01'::date NOT NULL,
    "time" time without time zone DEFAULT '00:00:00'::time without time zone NOT NULL,
    hall_id integer DEFAULT 0 NOT NULL,
    base_price numeric(10,2) DEFAULT 0 NOT NULL
);


ALTER TABLE public.seances OWNER TO postgres;


ALTER TABLE public.seances ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.seanses_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);



CREATE TABLE public.users (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255)
);


ALTER TABLE public.users OWNER TO postgres;


ALTER TABLE public.users ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);



ALTER TABLE ONLY public.halls
    ADD CONSTRAINT asd_pkey PRIMARY KEY (id);



ALTER TABLE ONLY public.films
    ADD CONSTRAINT films_pkey PRIMARY KEY (id);



ALTER TABLE ONLY public.halls_seat_schema
    ADD CONSTRAINT halls_seat_rates_pkey PRIMARY KEY (seat_num, hall_id);



ALTER TABLE ONLY public.halls_seat_schema
    ADD CONSTRAINT halls_seat_schema_hall_id_row_col_key UNIQUE (hall_id, "row", col);



ALTER TABLE ONLY public.halls_seat_schema
    ADD CONSTRAINT halls_seat_schema_seat_num_hall_id_key UNIQUE (seat_num, hall_id);



ALTER TABLE ONLY public.seance_tikets
    ADD CONSTRAINT seance_tikets_pkey PRIMARY KEY (id);



ALTER TABLE ONLY public.seances
    ADD CONSTRAINT seanses_pkey PRIMARY KEY (id);



ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);



CREATE UNIQUE INDEX seance_tikets_seance_id_seat_id_idx ON public.seance_tikets USING btree (seance_id, seat_num);



CREATE UNIQUE INDEX seances_date_time_hall_id_idx ON public.seances USING btree (date, "time", hall_id);



CREATE UNIQUE INDEX users_email_idx ON public.users USING btree (email);



ALTER TABLE ONLY public.halls_seat_schema
    ADD CONSTRAINT halls_seat_rates_hall_id_fkey FOREIGN KEY (hall_id) REFERENCES public.halls(id);



ALTER TABLE ONLY public.seance_tikets
    ADD CONSTRAINT seance_tikets_seance_id_fkey FOREIGN KEY (seance_id) REFERENCES public.seances(id);



ALTER TABLE ONLY public.seance_tikets
    ADD CONSTRAINT seance_tikets_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id);



ALTER TABLE ONLY public.seances
    ADD CONSTRAINT seances_film_id_fkey FOREIGN KEY (film_id) REFERENCES public.films(id);



ALTER TABLE ONLY public.seances
    ADD CONSTRAINT seances_hall_id_fkey FOREIGN KEY (hall_id) REFERENCES public.halls(id);




