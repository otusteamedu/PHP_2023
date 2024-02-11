--
-- PostgreSQL database dump
--

-- Dumped from database version 12.12
-- Dumped by pg_dump version 12.12

-- Started on 2024-02-11 13:58:33

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

--
-- TOC entry 2873 (class 1262 OID 16575)
-- Name: movies; Type: DATABASE; Schema: -; Owner: postgres
--

CREATE DATABASE movies WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'Russian_Russia.1251' LC_CTYPE = 'Russian_Russia.1251';


ALTER DATABASE movies OWNER TO postgres;

\connect movies

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
-- TOC entry 205 (class 1259 OID 16589)
-- Name: attribute_types; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.attribute_types (
    uid bigint NOT NULL,
    attribute_type_name character varying NOT NULL
);


ALTER TABLE public.attribute_types OWNER TO postgres;

--
-- TOC entry 204 (class 1259 OID 16587)
-- Name: attribute_types_uid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.attribute_types_uid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.attribute_types_uid_seq OWNER TO postgres;

--
-- TOC entry 2874 (class 0 OID 0)
-- Dependencies: 204
-- Name: attribute_types_uid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.attribute_types_uid_seq OWNED BY public.attribute_types.uid;


--
-- TOC entry 209 (class 1259 OID 16627)
-- Name: attribute_values; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.attribute_values (
    uid bigint NOT NULL,
    film_id bigint NOT NULL,
    attribute_id bigint NOT NULL,
    value_varchar character varying(255),
    value_text text,
    value_date date,
    value_numeric numeric(18,2),
    value_integer integer,
    value_boolean boolean
);


ALTER TABLE public.attribute_values OWNER TO postgres;

--
-- TOC entry 208 (class 1259 OID 16625)
-- Name: attribute_values_uid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.attribute_values_uid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.attribute_values_uid_seq OWNER TO postgres;

--
-- TOC entry 2875 (class 0 OID 0)
-- Dependencies: 208
-- Name: attribute_values_uid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.attribute_values_uid_seq OWNED BY public.attribute_values.uid;


--
-- TOC entry 207 (class 1259 OID 16611)
-- Name: attributes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.attributes (
    uid bigint NOT NULL,
    attribute_name character varying NOT NULL,
    attribute_type_id bigint NOT NULL
);


ALTER TABLE public.attributes OWNER TO postgres;

--
-- TOC entry 206 (class 1259 OID 16609)
-- Name: attributes_uid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.attributes_uid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.attributes_uid_seq OWNER TO postgres;

--
-- TOC entry 2876 (class 0 OID 0)
-- Dependencies: 206
-- Name: attributes_uid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.attributes_uid_seq OWNED BY public.attributes.uid;


--
-- TOC entry 203 (class 1259 OID 16578)
-- Name: films; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.films (
    uid bigint NOT NULL,
    film_name character varying NOT NULL,
    year character varying(4) NOT NULL,
    age_category character varying(3) NOT NULL
);


ALTER TABLE public.films OWNER TO postgres;

--
-- TOC entry 202 (class 1259 OID 16576)
-- Name: films_uid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.films_uid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.films_uid_seq OWNER TO postgres;

--
-- TOC entry 2877 (class 0 OID 0)
-- Dependencies: 202
-- Name: films_uid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.films_uid_seq OWNED BY public.films.uid;


--
-- TOC entry 211 (class 1259 OID 24767)
-- Name: view_actual_tasks; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.view_actual_tasks AS
 SELECT (((((films.film_name)::text || ' ('::text) || (films.year)::text) || ') '::text) || (films.age_category)::text) AS "Фильм",
    attributes.attribute_name AS "Задача",
    (attribute_values.value_date)::text AS "Дата выполнения"
   FROM (((public.films
     JOIN public.attribute_values ON ((films.uid = attribute_values.film_id)))
     JOIN public.attributes ON ((attributes.uid = attribute_values.attribute_id)))
     JOIN public.attribute_types ON ((attribute_types.uid = attributes.attribute_type_id)))
  WHERE (((attribute_values.value_date = CURRENT_DATE) OR (attribute_values.value_date = (CURRENT_DATE + '20 days'::interval))) AND (attribute_types.uid = 15))
  ORDER BY attribute_values.value_date, films.uid;


ALTER TABLE public.view_actual_tasks OWNER TO postgres;

--
-- TOC entry 210 (class 1259 OID 24760)
-- Name: view_film_info; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.view_film_info AS
 SELECT (((((films.film_name)::text || ' ('::text) || (films.year)::text) || ') '::text) || (films.age_category)::text) AS "Фильм",
    attribute_types.attribute_type_name AS "Тип атрибута",
    attributes.attribute_name AS "Атрибут",
        CASE
            WHEN (attribute_values.value_varchar IS NOT NULL) THEN attribute_values.value_varchar
            WHEN (attribute_values.value_text IS NOT NULL) THEN (attribute_values.value_text)::character varying
            WHEN (attribute_values.value_date IS NOT NULL) THEN ((attribute_values.value_date)::text)::character varying
            WHEN (attribute_values.value_numeric IS NOT NULL) THEN ((attribute_values.value_numeric)::text)::character varying
            WHEN (attribute_values.value_integer IS NOT NULL) THEN ((attribute_values.value_integer)::text)::character varying
            WHEN (attribute_values.value_boolean IS NOT NULL) THEN ((attribute_values.value_boolean)::text)::character varying
            ELSE NULL::character varying
        END AS "Значение"
   FROM (((public.films
     JOIN public.attribute_values ON ((films.uid = attribute_values.film_id)))
     JOIN public.attributes ON ((attributes.uid = attribute_values.attribute_id)))
     JOIN public.attribute_types ON ((attribute_types.uid = attributes.attribute_type_id)))
  ORDER BY films.year, attributes.uid;


ALTER TABLE public.view_film_info OWNER TO postgres;

--
-- TOC entry 2718 (class 2604 OID 16592)
-- Name: attribute_types uid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.attribute_types ALTER COLUMN uid SET DEFAULT nextval('public.attribute_types_uid_seq'::regclass);


--
-- TOC entry 2720 (class 2604 OID 16630)
-- Name: attribute_values uid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.attribute_values ALTER COLUMN uid SET DEFAULT nextval('public.attribute_values_uid_seq'::regclass);


--
-- TOC entry 2719 (class 2604 OID 16614)
-- Name: attributes uid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.attributes ALTER COLUMN uid SET DEFAULT nextval('public.attributes_uid_seq'::regclass);


--
-- TOC entry 2717 (class 2604 OID 16581)
-- Name: films uid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.films ALTER COLUMN uid SET DEFAULT nextval('public.films_uid_seq'::regclass);


--
-- TOC entry 2863 (class 0 OID 16589)
-- Dependencies: 205
-- Data for Name: attribute_types; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.attribute_types (uid, attribute_type_name) VALUES (1, 'Рецензии');
INSERT INTO public.attribute_types (uid, attribute_type_name) VALUES (3, 'Премии');
INSERT INTO public.attribute_types (uid, attribute_type_name) VALUES (6, 'Сборы');
INSERT INTO public.attribute_types (uid, attribute_type_name) VALUES (10, 'Важные даты');
INSERT INTO public.attribute_types (uid, attribute_type_name) VALUES (15, 'Служебные даты');


--
-- TOC entry 2867 (class 0 OID 16627)
-- Dependencies: 209
-- Data for Name: attribute_values; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.attribute_values (uid, film_id, attribute_id, value_varchar, value_text, value_date, value_numeric, value_integer, value_boolean) VALUES (1, 1, 2, 'Лучшие визуальные эффекты', NULL, NULL, NULL, NULL, NULL);
INSERT INTO public.attribute_values (uid, film_id, attribute_id, value_varchar, value_text, value_date, value_numeric, value_integer, value_boolean) VALUES (3, 1, 2, 'Лучшая операторская работа', NULL, NULL, NULL, NULL, NULL);
INSERT INTO public.attribute_values (uid, film_id, attribute_id, value_varchar, value_text, value_date, value_numeric, value_integer, value_boolean) VALUES (6, 1, 2, 'Лучшая работа художника-постановщика', NULL, NULL, NULL, NULL, NULL);
INSERT INTO public.attribute_values (uid, film_id, attribute_id, value_varchar, value_text, value_date, value_numeric, value_integer, value_boolean) VALUES (10, 1, 4, NULL, NULL, NULL, 2849856965.00, NULL, NULL);
INSERT INTO public.attribute_values (uid, film_id, attribute_id, value_varchar, value_text, value_date, value_numeric, value_integer, value_boolean) VALUES (31, 1, 7, NULL, NULL, NULL, 119903658.00, NULL, NULL);
INSERT INTO public.attribute_values (uid, film_id, attribute_id, value_varchar, value_text, value_date, value_numeric, value_integer, value_boolean) VALUES (37, 1, 20, NULL, 'Пик карьеры самого Джеймса Кэмерона – как с художественной, так и с технической точек зрения. Визуальные эффекты фильма сражают наповал; по части воссоздания другого мира рядом поставить просто нечего. И, конечно же, не забыта и история – и именно в ней маэстро раскрывается со своей самой лучшей стороны. Дергая за ниточки ровно тогда, когда это нужно, предлагая оглушительное буйство финала и реверанс, от которого мурашки бегут по коже', NULL, NULL, NULL, NULL);
INSERT INTO public.attribute_values (uid, film_id, attribute_id, value_varchar, value_text, value_date, value_numeric, value_integer, value_boolean) VALUES (44, 1, 25, NULL, 'Фильм Аватар 2009 года выпуска это художественное произведение, имеющие фантастический оттенок. Мне всегда нравились фильмы, которые повествуют о будущем нашей планеты. Точно так же и здесь, где действие проходило в очень далеком расстоянии от нашей Земли. Вы можете представить себе два световых года? Лететь такое расстояние с нашими, пока что ''технологиями'', однозначно тысячи и тысячи лет. Это уже может будоражить воображение зрителя. Представление такого в реальности, а возможно ли вообще это действо в настоящем мире? Именно этим и завлекла меня кинокартина.', NULL, NULL, NULL, NULL);
INSERT INTO public.attribute_values (uid, film_id, attribute_id, value_varchar, value_text, value_date, value_numeric, value_integer, value_boolean) VALUES (52, 1, 31, NULL, NULL, '2009-12-10', NULL, NULL, NULL);
INSERT INTO public.attribute_values (uid, film_id, attribute_id, value_varchar, value_text, value_date, value_numeric, value_integer, value_boolean) VALUES (101, 1, 38, NULL, NULL, '2009-12-15', NULL, NULL, NULL);
INSERT INTO public.attribute_values (uid, film_id, attribute_id, value_varchar, value_text, value_date, value_numeric, value_integer, value_boolean) VALUES (174, 1, 55, NULL, NULL, '2024-03-02', NULL, NULL, NULL);
INSERT INTO public.attribute_values (uid, film_id, attribute_id, value_varchar, value_text, value_date, value_numeric, value_integer, value_boolean) VALUES (185, 1, 46, NULL, NULL, '2024-03-02', NULL, NULL, NULL);


--
-- TOC entry 2865 (class 0 OID 16611)
-- Dependencies: 207
-- Data for Name: attributes; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.attributes (uid, attribute_name, attribute_type_id) VALUES (2, 'Премия "Оскар"', 3);
INSERT INTO public.attributes (uid, attribute_name, attribute_type_id) VALUES (4, 'Сборы в мире', 6);
INSERT INTO public.attributes (uid, attribute_name, attribute_type_id) VALUES (7, 'Сборы в России', 6);
INSERT INTO public.attributes (uid, attribute_name, attribute_type_id) VALUES (20, 'Рецензии зрителей', 1);
INSERT INTO public.attributes (uid, attribute_name, attribute_type_id) VALUES (25, 'Рецензии кинокритиков', 1);
INSERT INTO public.attributes (uid, attribute_name, attribute_type_id) VALUES (31, 'Премьера в мире', 10);
INSERT INTO public.attributes (uid, attribute_name, attribute_type_id) VALUES (38, 'Премьера в Росии', 10);
INSERT INTO public.attributes (uid, attribute_name, attribute_type_id) VALUES (46, 'Начало продаж билетов', 15);
INSERT INTO public.attributes (uid, attribute_name, attribute_type_id) VALUES (55, 'Старт рекламы', 15);


--
-- TOC entry 2861 (class 0 OID 16578)
-- Dependencies: 203
-- Data for Name: films; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.films (uid, film_name, year, age_category) VALUES (1, 'Аватар', '2009', '12+');


--
-- TOC entry 2878 (class 0 OID 0)
-- Dependencies: 204
-- Name: attribute_types_uid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.attribute_types_uid_seq', 27, true);


--
-- TOC entry 2879 (class 0 OID 0)
-- Dependencies: 208
-- Name: attribute_values_uid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.attribute_values_uid_seq', 196, true);


--
-- TOC entry 2880 (class 0 OID 0)
-- Dependencies: 206
-- Name: attributes_uid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.attributes_uid_seq', 64, true);


--
-- TOC entry 2881 (class 0 OID 0)
-- Dependencies: 202
-- Name: films_uid_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.films_uid_seq', 2, true);


--
-- TOC entry 2724 (class 2606 OID 16594)
-- Name: attribute_types attribute_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.attribute_types
    ADD CONSTRAINT attribute_types_pkey PRIMARY KEY (uid);


--
-- TOC entry 2728 (class 2606 OID 16632)
-- Name: attribute_values attribute_values_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.attribute_values
    ADD CONSTRAINT attribute_values_pkey PRIMARY KEY (uid);


--
-- TOC entry 2726 (class 2606 OID 16616)
-- Name: attributes attributes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.attributes
    ADD CONSTRAINT attributes_pkey PRIMARY KEY (uid);


--
-- TOC entry 2722 (class 2606 OID 16586)
-- Name: films films_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.films
    ADD CONSTRAINT films_pkey PRIMARY KEY (uid);


--
-- TOC entry 2731 (class 2606 OID 16638)
-- Name: attribute_values FK_attribute_values_attributes; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.attribute_values
    ADD CONSTRAINT "FK_attribute_values_attributes" FOREIGN KEY (attribute_id) REFERENCES public.attributes(uid);


--
-- TOC entry 2730 (class 2606 OID 16633)
-- Name: attribute_values FK_attribute_values_films; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.attribute_values
    ADD CONSTRAINT "FK_attribute_values_films" FOREIGN KEY (film_id) REFERENCES public.films(uid);


--
-- TOC entry 2729 (class 2606 OID 16620)
-- Name: attributes FK_attributes_attribute_types; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.attributes
    ADD CONSTRAINT "FK_attributes_attribute_types" FOREIGN KEY (attribute_type_id) REFERENCES public.attribute_types(uid);


-- Completed on 2024-02-11 13:58:33

--
-- PostgreSQL database dump complete
--

