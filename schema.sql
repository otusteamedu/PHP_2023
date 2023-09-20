--
-- PostgreSQL database dump
--

-- Dumped from database version 12.3
-- Dumped by pg_dump version 12.2

-- Started on 2023-09-20 17:42:38 UTC

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
-- TOC entry 203 (class 1259 OID 16390)
-- Name: movie_attributes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.movie_attributes (
                                         id integer NOT NULL,
                                         name character varying(255) NOT NULL
);


ALTER TABLE public.movie_attributes OWNER TO postgres;

--
-- TOC entry 205 (class 1259 OID 16397)
-- Name: attribute_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.movie_attributes ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.attribute_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 202 (class 1259 OID 16385)
-- Name: movies; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.movies (
                               id integer NOT NULL,
                               name character varying(255) NOT NULL
);


ALTER TABLE public.movies OWNER TO postgres;

--
-- TOC entry 204 (class 1259 OID 16395)
-- Name: entity_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.movies ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.entity_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 206 (class 1259 OID 16399)
-- Name: movie_attribute_types; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.movie_attribute_types (
                                              id integer NOT NULL,
                                              name character varying(255) NOT NULL
);


ALTER TABLE public.movie_attribute_types OWNER TO postgres;

--
-- TOC entry 208 (class 1259 OID 16406)
-- Name: movie_values; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.movie_values (
                                     value_text text,
                                     value_bool boolean,
                                     value_date date,
                                     value_float real,
                                     value_numeric numeric(12,2),
                                     value_int integer,
                                     entity_id integer NOT NULL,
                                     attribute_id integer NOT NULL,
                                     type_id integer NOT NULL
);


ALTER TABLE public.movie_values OWNER TO postgres;

--
-- TOC entry 210 (class 1259 OID 16449)
-- Name: task1; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.task1 AS
SELECT m.name AS "Название фильма",
       ma.name AS "Атрибут",
       mat.name AS "Тип атрибута",
       CASE
           WHEN (mat.id = 2) THEN (mv.value_bool)::text
           WHEN (mat.id = ANY (ARRAY[3, 4])) THEN (mv.value_date)::text
           WHEN (mat.id = 1) THEN mv.value_text
           ELSE NULL::text
           END AS "Значение"
FROM (((public.movies m
    LEFT JOIN public.movie_values mv ON ((mv.entity_id = m.id)))
    LEFT JOIN public.movie_attributes ma ON ((ma.id = mv.attribute_id)))
    LEFT JOIN public.movie_attribute_types mat ON ((mat.id = mv.type_id)))
WHERE (m.id = 1);


ALTER TABLE public.task1 OWNER TO postgres;

--
-- TOC entry 209 (class 1259 OID 16444)
-- Name: task2; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.task2 AS
SELECT m.name AS "Название фильма",
       tmp.task1 AS "Задачи актуальные на сегодня",
       tmp.task2 AS "Задачи актуальные через 20 дней"
FROM (public.movies m
    LEFT JOIN ( SELECT mv.entity_id,
                       CASE
                           WHEN (mv.value_date >= CURRENT_DATE) THEN ma.name
                           ELSE NULL::character varying
                END AS task1,
                CASE
                    WHEN (mv.value_date > (CURRENT_DATE + '100 days'::interval day)) THEN ma.name
                    ELSE NULL::character varying
                END AS task2
                FROM ((public.movie_values mv
                    LEFT JOIN public.movie_attributes ma ON ((ma.id = mv.attribute_id)))
                    LEFT JOIN public.movie_attribute_types mat ON ((mat.id = mv.type_id)))
                WHERE (mat.id = ANY (ARRAY[3, 4]))) tmp ON ((tmp.entity_id = m.id)));


ALTER TABLE public.task2 OWNER TO postgres;

--
-- TOC entry 207 (class 1259 OID 16404)
-- Name: type_attribute_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.movie_attribute_types ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.type_attribute_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 2997 (class 0 OID 16399)
-- Dependencies: 206
-- Data for Name: movie_attribute_types; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.movie_attribute_types (id, name) OVERRIDING SYSTEM VALUE VALUES (1, 'reviews');
INSERT INTO public.movie_attribute_types (id, name) OVERRIDING SYSTEM VALUE VALUES (2, 'premium');
INSERT INTO public.movie_attribute_types (id, name) OVERRIDING SYSTEM VALUE VALUES (3, 'important dates');
INSERT INTO public.movie_attribute_types (id, name) OVERRIDING SYSTEM VALUE VALUES (4, 'service dates');
INSERT INTO public.movie_attribute_types (id, name) OVERRIDING SYSTEM VALUE VALUES (6, 'duration');
INSERT INTO public.movie_attribute_types (id, name) OVERRIDING SYSTEM VALUE VALUES (7, 'sum of money at the global box office');
INSERT INTO public.movie_attribute_types (id, name) OVERRIDING SYSTEM VALUE VALUES (8, 'the amount of money in the Russian Federation');


--
-- TOC entry 2994 (class 0 OID 16390)
-- Dependencies: 203
-- Data for Name: movie_attributes; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.movie_attributes (id, name) OVERRIDING SYSTEM VALUE VALUES (3, 'critics reviews');
INSERT INTO public.movie_attributes (id, name) OVERRIDING SYSTEM VALUE VALUES (4, 'review of the film academy');
INSERT INTO public.movie_attributes (id, name) OVERRIDING SYSTEM VALUE VALUES (5, 'Oscar');
INSERT INTO public.movie_attributes (id, name) OVERRIDING SYSTEM VALUE VALUES (6, 'Nika');
INSERT INTO public.movie_attributes (id, name) OVERRIDING SYSTEM VALUE VALUES (7, 'world premiere');
INSERT INTO public.movie_attributes (id, name) OVERRIDING SYSTEM VALUE VALUES (8, 'premiere in Russia');
INSERT INTO public.movie_attributes (id, name) OVERRIDING SYSTEM VALUE VALUES (9, 'ticket sales start date');
INSERT INTO public.movie_attributes (id, name) OVERRIDING SYSTEM VALUE VALUES (10, 'when to launch ads on TV');


--
-- TOC entry 2999 (class 0 OID 16406)
-- Dependencies: 208
-- Data for Name: movie_values; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.movie_values (value_text, value_bool, value_date, entity_id, attribute_id, type_id, value_float, value_numeric, value_int) VALUES (NULL, true, NULL, 1, 5, 2, NULL, NULL, NULL);
INSERT INTO public.movie_values (value_text, value_bool, value_date, entity_id, attribute_id, type_id, value_float, value_numeric, value_int) VALUES ('Какая-то рецензия...', NULL, NULL, 1, 3, 1, NULL, NULL, NULL);
INSERT INTO public.movie_values (value_text, value_bool, value_date, entity_id, attribute_id, type_id, value_float, value_numeric, value_int) VALUES (NULL, NULL, '2024-01-01', 1, 7, 3, NULL, NULL, NULL);
INSERT INTO public.movie_values (value_text, value_bool, value_date, entity_id, attribute_id, type_id, value_float, value_numeric, value_int) VALUES (NULL, NULL, '2024-05-01', 1, 8, 3, NULL, NULL, NULL);
INSERT INTO public.movie_values (value_text, value_bool, value_date, entity_id, attribute_id, type_id, value_float, value_numeric, value_int) VALUES (NULL, NULL, '2023-10-11', 1, 10, 4, NULL, NULL, NULL);


--
-- TOC entry 2993 (class 0 OID 16385)
-- Dependencies: 202
-- Data for Name: movies; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.movies (id, name) OVERRIDING SYSTEM VALUE VALUES (1, 'Название 1');
INSERT INTO public.movies (id, name) OVERRIDING SYSTEM VALUE VALUES (2, 'Название 2');
INSERT INTO public.movies (id, name) OVERRIDING SYSTEM VALUE VALUES (3, 'Название 3');


--
-- TOC entry 3005 (class 0 OID 0)
-- Dependencies: 205
-- Name: attribute_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.attribute_id_seq', 11, true);


--
-- TOC entry 3006 (class 0 OID 0)
-- Dependencies: 204
-- Name: entity_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.entity_id_seq', 3, true);


--
-- TOC entry 3007 (class 0 OID 0)
-- Dependencies: 207
-- Name: type_attribute_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.type_attribute_id_seq', 8, true);


--
-- TOC entry 2852 (class 2606 OID 16394)
-- Name: movie_attributes attribute_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.movie_attributes
    ADD CONSTRAINT attribute_pkey PRIMARY KEY (id);


--
-- TOC entry 2850 (class 2606 OID 16389)
-- Name: movies entity_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.movies
    ADD CONSTRAINT entity_pkey PRIMARY KEY (id);


--
-- TOC entry 2854 (class 2606 OID 16403)
-- Name: movie_attribute_types type_attribute_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.movie_attribute_types
    ADD CONSTRAINT type_attribute_pkey PRIMARY KEY (id);


--
-- TOC entry 2860 (class 2606 OID 16415)
-- Name: movie_values value_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.movie_values
    ADD CONSTRAINT value_pkey PRIMARY KEY (entity_id, attribute_id, type_id);


--
-- TOC entry 2855 (class 1259 OID 16437)
-- Name: value_date; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX value_date ON public.movie_values USING btree (value_date);


--
-- TOC entry 2856 (class 1259 OID 16604)
-- Name: value_float; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX value_float ON public.movie_values USING btree (value_float);


--
-- TOC entry 2857 (class 1259 OID 16606)
-- Name: value_int; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX value_int ON public.movie_values USING btree (value_int);


--
-- TOC entry 2858 (class 1259 OID 16605)
-- Name: value_numeric; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX value_numeric ON public.movie_values USING btree (value_numeric);


--
-- TOC entry 2861 (class 1259 OID 16436)
-- Name: value_text; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX value_text ON public.movie_values USING btree (value_text);


--
-- TOC entry 2863 (class 2606 OID 16426)
-- Name: movie_values value_attribute_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.movie_values
    ADD CONSTRAINT value_attribute_id_fkey FOREIGN KEY (attribute_id) REFERENCES public.movie_attributes(id) NOT VALID;


--
-- TOC entry 2862 (class 2606 OID 16421)
-- Name: movie_values value_entity_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.movie_values
    ADD CONSTRAINT value_entity_id_fkey FOREIGN KEY (entity_id) REFERENCES public.movies(id) NOT VALID;


--
-- TOC entry 2864 (class 2606 OID 16431)
-- Name: movie_values value_type_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.movie_values
    ADD CONSTRAINT value_type_id_fkey FOREIGN KEY (type_id) REFERENCES public.movie_attribute_types(id) NOT VALID;


-- Completed on 2023-09-20 17:42:39 UTC

--
-- PostgreSQL database dump complete
--

