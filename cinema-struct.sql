--
-- PostgreSQL database dump
--

-- Dumped from database version 16.1 (Debian 16.1-1.pgdg120+1)
-- Dumped by pg_dump version 16.1 (Debian 16.1-1.pgdg120+1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: film_attributes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.film_attributes (
    id integer NOT NULL,
    name character varying(255) DEFAULT ''::character varying NOT NULL,
    type_id integer DEFAULT 0 NOT NULL,
    title character varying(255) DEFAULT ''::character varying NOT NULL
);


ALTER TABLE public.film_attributes OWNER TO postgres;

--
-- Name: film_attributes_types; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.film_attributes_types (
    id integer NOT NULL,
    name character varying(255) DEFAULT ''::character varying NOT NULL,
    type character varying(255) DEFAULT ''::character varying NOT NULL
);


ALTER TABLE public.film_attributes_types OWNER TO postgres;

--
-- Name: film_attributes_types_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.film_attributes_types ALTER COLUMN id ADD GENERATED BY DEFAULT AS IDENTITY (
    SEQUENCE NAME public.film_attributes_types_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: film_attributes_vals; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.film_attributes_vals (
    film_id integer DEFAULT 0 NOT NULL,
    attr_id integer DEFAULT 0 NOT NULL,
    val_text text DEFAULT ''::text NOT NULL,
    val_float double precision DEFAULT 0 NOT NULL,
    val_time time without time zone DEFAULT '00:00:00'::time without time zone NOT NULL,
    val_date date DEFAULT '0001-01-01'::date NOT NULL,
    val_int integer DEFAULT 0 NOT NULL
);


ALTER TABLE public.film_attributes_vals OWNER TO postgres;

--
-- Name: film_attrs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.film_attributes ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.film_attrs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: films; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.films (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    length time(6) without time zone DEFAULT '00:00:00'::time without time zone NOT NULL,
    kp_id integer DEFAULT 0 NOT NULL
);


ALTER TABLE public.films OWNER TO postgres;

--
-- Name: films_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.films ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.films_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: halls; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.halls (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    count_seats integer DEFAULT 0 NOT NULL,
    price_ratio real DEFAULT 1 NOT NULL
);


ALTER TABLE public.halls OWNER TO postgres;

--
-- Name: halls_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.halls ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.halls_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: halls_seat_schema; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.halls_seat_schema (
    seat_num integer DEFAULT 0 NOT NULL,
    hall_id integer DEFAULT 0 NOT NULL,
    price_ratio real NOT NULL,
    "row" smallint DEFAULT 0 NOT NULL,
    col smallint DEFAULT 0 NOT NULL
);


ALTER TABLE public.halls_seat_schema OWNER TO postgres;

--
-- Name: seance_tikets; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.seance_tikets (
    id integer NOT NULL,
    seance_id integer DEFAULT 0 NOT NULL,
    user_id integer DEFAULT 0 NOT NULL,
    seat_num integer DEFAULT 0 NOT NULL,
    price numeric(10,2) DEFAULT 0 NOT NULL
);


ALTER TABLE public.seance_tikets OWNER TO postgres;

--
-- Name: seance_tikets_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.seance_tikets ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.seance_tikets_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: seances; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.seances (
    id integer NOT NULL,
    film_id integer NOT NULL,
    date date DEFAULT '1999-01-01'::date NOT NULL,
    "time" time(6) without time zone DEFAULT '00:00:00'::time without time zone NOT NULL,
    hall_id integer DEFAULT 0 NOT NULL,
    base_price numeric(10,2) DEFAULT 0 NOT NULL,
    date_unix_ts integer DEFAULT 0 NOT NULL
);


ALTER TABLE public.seances OWNER TO postgres;

--
-- Name: seances_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.seances ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.seances_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: settings; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.settings (
    name character varying(255) NOT NULL,
    val text DEFAULT ''::text NOT NULL
);


ALTER TABLE public.settings OWNER TO postgres;

--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255)
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.users ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: v_important_dates; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.v_important_dates AS
 SELECT a.name,
    c.title,
    b.val_date AS to_date
   FROM ((public.films a
     JOIN public.film_attributes_vals b ON ((b.film_id = a.id)))
     JOIN public.film_attributes c ON ((c.id = b.attr_id)))
  WHERE ((c.type_id = 4) AND ((b.val_date = ( SELECT to_date(settings.val, 'YYYY-MM-DD'::text) AS to_date
           FROM public.settings
          WHERE ((settings.name)::text = 'curdate'::text))) OR (b.val_date = ( SELECT (to_date(settings.val, 'YYYY-MM-DD'::text) + '20 days'::interval)
           FROM public.settings
          WHERE ((settings.name)::text = 'curdate'::text)))));


ALTER VIEW public.v_important_dates OWNER TO postgres;

--
-- Name: v_marketing; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.v_marketing AS
 SELECT f.id,
    f.name,
    fa.title AS attr,
    fat.type,
        CASE
            WHEN ((fat.type)::text = 'int'::text) THEN (fav.val_int)::text
            WHEN ((fat.type)::text = 'time'::text) THEN to_char((fav.val_time)::interval, 'HH24:MI:SS'::text)
            WHEN ((fat.type)::text = 'date'::text) THEN to_char((fav.val_date)::timestamp with time zone, 'dd.mm.yyyy'::text)
            WHEN ((fat.type)::text = 'float'::text) THEN (fav.val_float)::text
            WHEN ((fat.type)::text = 'checkbox'::text) THEN array_to_string(string_to_array(fav.val_text, '|'::text), ', '::text)
            ELSE fav.val_text
        END AS formatted_value
   FROM (((public.films f
     JOIN public.film_attributes_vals fav ON ((fav.film_id = f.id)))
     JOIN public.film_attributes fa ON ((fa.id = fav.attr_id)))
     JOIN public.film_attributes_types fat ON ((fat.id = fa.type_id)))
  ORDER BY f.name;


ALTER VIEW public.v_marketing OWNER TO postgres;

--
-- Name: halls asd_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.halls
    ADD CONSTRAINT asd_pkey PRIMARY KEY (id);


--
-- Name: film_attributes_types film_attributes_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film_attributes_types
    ADD CONSTRAINT film_attributes_types_pkey PRIMARY KEY (id);


--
-- Name: film_attributes_vals film_attributes_vals_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film_attributes_vals
    ADD CONSTRAINT film_attributes_vals_pkey PRIMARY KEY (film_id, attr_id);


--
-- Name: film_attributes film_attrs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film_attributes
    ADD CONSTRAINT film_attrs_pkey PRIMARY KEY (id);


--
-- Name: films films_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.films
    ADD CONSTRAINT films_pkey PRIMARY KEY (id);


--
-- Name: halls_seat_schema halls_seat_rates_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.halls_seat_schema
    ADD CONSTRAINT halls_seat_rates_pkey PRIMARY KEY (seat_num, hall_id);


--
-- Name: halls_seat_schema halls_seat_schema_hall_id_row_col_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.halls_seat_schema
    ADD CONSTRAINT halls_seat_schema_hall_id_row_col_key UNIQUE (hall_id, "row", col);


--
-- Name: halls_seat_schema halls_seat_schema_seat_num_hall_id_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.halls_seat_schema
    ADD CONSTRAINT halls_seat_schema_seat_num_hall_id_key UNIQUE (seat_num, hall_id);


--
-- Name: seance_tikets seance_tikets_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.seance_tikets
    ADD CONSTRAINT seance_tikets_pkey PRIMARY KEY (id);


--
-- Name: seances seances_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.seances
    ADD CONSTRAINT seances_pkey PRIMARY KEY (id);


--
-- Name: settings settings_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.settings
    ADD CONSTRAINT settings_pkey PRIMARY KEY (name);


--
-- Name: film_attributes_name_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX film_attributes_name_idx ON public.film_attributes USING btree (name);


--
-- Name: film_attributes_type_id_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX film_attributes_type_id_idx ON public.film_attributes USING btree (type_id);


--
-- Name: film_attributes_vals_attr_id_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX film_attributes_vals_attr_id_idx ON public.film_attributes_vals USING btree (attr_id);


--
-- Name: film_attributes_vals_film_id_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX film_attributes_vals_film_id_idx ON public.film_attributes_vals USING btree (film_id);


--
-- Name: seance_tikets_seance_id_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX seance_tikets_seance_id_idx ON public.seance_tikets USING btree (seance_id);


--
-- Name: seances_date_id_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX seances_date_id_idx ON public.seances USING btree (date);


--
-- Name: seances_date_unix_ts; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX seances_date_unix_ts ON public.seances USING btree (date_unix_ts);


--
-- Name: seances_film_id_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX seances_film_id_idx ON public.seances USING btree (film_id);


--
-- Name: film_attributes film_attributes_type_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film_attributes
    ADD CONSTRAINT film_attributes_type_id_fkey FOREIGN KEY (type_id) REFERENCES public.film_attributes_types(id);


--
-- Name: film_attributes_vals film_attributes_vals_attr_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film_attributes_vals
    ADD CONSTRAINT film_attributes_vals_attr_id_fkey FOREIGN KEY (attr_id) REFERENCES public.film_attributes(id);


--
-- Name: film_attributes_vals film_attributes_vals_film_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film_attributes_vals
    ADD CONSTRAINT film_attributes_vals_film_id_fkey FOREIGN KEY (film_id) REFERENCES public.films(id);


--
-- PostgreSQL database dump complete
--

