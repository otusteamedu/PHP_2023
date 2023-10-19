--
-- PostgreSQL database dump
--

-- Dumped from database version 16.0 (Debian 16.0-1.pgdg120+1)
-- Dumped by pg_dump version 16.0 (Debian 16.0-1.pgdg120+1)

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
-- Name: film_attribute_types; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.film_attribute_types (
    id integer NOT NULL,
    type character varying(100) NOT NULL,
    value_name character varying(150) NOT NULL,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone NOT NULL
);


ALTER TABLE public.film_attribute_types OWNER TO postgres;

--
-- Name: film_attribute_types_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.film_attribute_types_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.film_attribute_types_id_seq OWNER TO postgres;

--
-- Name: film_attribute_types_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.film_attribute_types_id_seq OWNED BY public.film_attribute_types.id;


--
-- Name: film_attributes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.film_attributes (
    id integer NOT NULL,
    name character varying(100) NOT NULL,
    film_attribute_type_id integer,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone NOT NULL
);


ALTER TABLE public.film_attributes OWNER TO postgres;

--
-- Name: film_attributes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.film_attributes_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.film_attributes_id_seq OWNER TO postgres;

--
-- Name: film_attributes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.film_attributes_id_seq OWNED BY public.film_attributes.id;


--
-- Name: film_values; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.film_values (
    id integer NOT NULL,
    film_to_attribute_id integer NOT NULL,
    value_boolean boolean,
    value_date timestamp without time zone,
    value_varchar_200 character varying(200),
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone NOT NULL
);


ALTER TABLE public.film_values OWNER TO postgres;

--
-- Name: film_values_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.film_values_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.film_values_id_seq OWNER TO postgres;

--
-- Name: film_values_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.film_values_id_seq OWNED BY public.film_values.id;


--
-- Name: films; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.films (
    id smallint NOT NULL,
    title character varying(200) NOT NULL,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone NOT NULL
);


ALTER TABLE public.films OWNER TO postgres;

--
-- Name: films_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.films_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.films_id_seq OWNER TO postgres;

--
-- Name: films_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.films_id_seq OWNED BY public.films.id;


--
-- Name: films_to_attributes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.films_to_attributes (
    id integer NOT NULL,
    film_id integer NOT NULL,
    film_attribute_id integer NOT NULL,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone NOT NULL
);


ALTER TABLE public.films_to_attributes OWNER TO postgres;

--
-- Name: films_to_attributes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.films_to_attributes_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.films_to_attributes_id_seq OWNER TO postgres;

--
-- Name: films_to_attributes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.films_to_attributes_id_seq OWNED BY public.films_to_attributes.id;


--
-- Name: future_tasks; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.future_tasks AS
 SELECT f.title,
    a.name,
    v.value_date
   FROM (((public.films f
     JOIN public.films_to_attributes fa ON ((fa.film_id = f.id)))
     JOIN public.film_attributes a ON ((fa.film_attribute_id = a.id)))
     JOIN public.film_values v ON ((v.film_to_attribute_id = fa.id)))
  WHERE ((v.value_date >= date_add('2023-10-10 00:00:00+00'::timestamp with time zone, '20 days'::interval)) AND (((a.name)::text = 'Дата начала продажи билетов'::text) OR ((a.name)::text = 'Дата начала запуска рекламных компаний на ТВ'::text)));


ALTER VIEW public.future_tasks OWNER TO postgres;

--
-- Name: marketing; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.marketing AS
 SELECT fm.title,
    fat.value_name,
    fa.name,
    concat('', fv.value_boolean, fv.value_date, fv.value_varchar_200) AS value
   FROM ((((public.films fm
     JOIN public.films_to_attributes fta ON ((fm.id = fta.film_id)))
     JOIN public.film_attributes fa ON ((fa.id = fta.film_attribute_id)))
     JOIN public.film_attribute_types fat ON ((fa.film_attribute_type_id = fat.id)))
     JOIN public.film_values fv ON ((fta.id = fv.film_to_attribute_id)))
  ORDER BY fm.id, fa.id;


ALTER VIEW public.marketing OWNER TO postgres;

--
-- Name: today_tasks; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.today_tasks AS
 SELECT f.title,
    a.name,
    v.value_date
   FROM (((public.films f
     JOIN public.films_to_attributes fa ON ((fa.film_id = f.id)))
     JOIN public.film_attributes a ON ((fa.film_attribute_id = a.id)))
     JOIN public.film_values v ON ((v.film_to_attribute_id = fa.id)))
  WHERE ((v.value_date = '2023-10-10'::date) AND (((a.name)::text = 'Дата начала продажи билетов'::text) OR ((a.name)::text = 'Дата начала запуска рекламных компаний на ТВ'::text)));


ALTER VIEW public.today_tasks OWNER TO postgres;

--
-- Name: film_attribute_types id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film_attribute_types ALTER COLUMN id SET DEFAULT nextval('public.film_attribute_types_id_seq'::regclass);


--
-- Name: film_attributes id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film_attributes ALTER COLUMN id SET DEFAULT nextval('public.film_attributes_id_seq'::regclass);


--
-- Name: film_values id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film_values ALTER COLUMN id SET DEFAULT nextval('public.film_values_id_seq'::regclass);


--
-- Name: films id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.films ALTER COLUMN id SET DEFAULT nextval('public.films_id_seq'::regclass);


--
-- Name: films_to_attributes id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.films_to_attributes ALTER COLUMN id SET DEFAULT nextval('public.films_to_attributes_id_seq'::regclass);


--
-- Data for Name: film_attribute_types; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.film_attribute_types (id, type, value_name, created_at, updated_at) FROM stdin;
1	boolean	value_boolean	2023-10-09 19:09:36.27783	2023-10-09 19:09:36.27783
2	date	value_date	2023-10-09 19:10:10.911019	2023-10-09 19:10:10.911019
3	varchar_200	value_varchar_200	2023-10-09 19:10:24.416589	2023-10-09 19:10:24.416589
\.


--
-- Data for Name: film_attributes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.film_attributes (id, name, film_attribute_type_id, created_at, updated_at) FROM stdin;
1	Рецензии критиков	3	2023-10-09 19:17:03.382012	2023-10-09 19:17:03.382012
2	Рецензии Кинопоиска	3	2023-10-09 19:18:34.695041	2023-10-09 19:18:34.695041
3	Премия "Оскар"	1	2023-10-09 19:19:35.091925	2023-10-09 19:19:35.091925
4	Премия "Золотой глобус"	1	2023-10-09 19:19:49.888734	2023-10-09 19:19:49.888734
5	Премия "Ника"	1	2023-10-09 19:20:03.593872	2023-10-09 19:20:03.593872
6	Премия "Эмми"	1	2023-10-09 19:20:20.237189	2023-10-09 19:20:20.237189
7	Мировая премьера	2	2023-10-09 19:20:53.445254	2023-10-09 19:20:53.445254
8	Дата выхода в РФ	2	2023-10-09 19:21:04.188782	2023-10-09 19:21:04.188782
9	Дата начала продажи билетов	2	2023-10-09 19:22:10.172085	2023-10-09 19:22:10.172085
10	Дата начала запуска рекламных компаний на ТВ	2	2023-10-09 19:22:27.472201	2023-10-09 19:22:27.472201
\.


--
-- Data for Name: film_values; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.film_values (id, film_to_attribute_id, value_boolean, value_date, value_varchar_200, created_at, updated_at) FROM stdin;
1	1	t	\N	\N	2023-10-10 17:53:55.836104	2023-10-10 17:53:55.836104
2	2	t	\N	\N	2023-10-10 17:54:03.577585	2023-10-10 17:54:03.577585
3	7	t	\N	\N	2023-10-12 15:39:27.622524	2023-10-12 15:39:27.622524
4	3	\N	2020-07-08 00:00:00	\N	2023-10-10 18:09:02.915796	2023-10-10 18:09:02.915796
5	4	\N	2020-07-22 00:00:00	\N	2023-10-10 18:09:21.209775	2023-10-10 18:09:21.209775
6	5	\N	2023-10-10 00:00:00	\N	2023-10-10 18:12:59.69005	2023-10-10 18:12:59.69005
7	6	\N	2023-10-17 00:00:00	\N	2023-10-10 18:14:17.566536	2023-10-10 18:14:17.566536
8	8	\N	2004-08-05 00:00:00	\N	2023-10-12 15:40:45.483588	2023-10-12 15:40:45.483588
9	9	\N	2023-11-10 00:00:00	\N	2023-10-12 15:41:11.015783	2023-10-12 15:41:11.015783
10	10	\N	2023-09-01 00:00:00	\N	2023-10-12 15:41:22.838402	2023-10-12 15:41:22.838402
\.


--
-- Data for Name: films; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.films (id, title, created_at, updated_at) FROM stdin;
1	Начало	2023-10-10 17:46:11.450461	2023-10-10 17:46:11.450461
2	Я - робот	2023-10-10 17:46:39.650672	2023-10-10 17:46:39.650672
3	Неудержимые 4	2023-10-10 17:47:04.09176	2023-10-10 17:47:04.09176
\.


--
-- Data for Name: films_to_attributes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.films_to_attributes (id, film_id, film_attribute_id, created_at, updated_at) FROM stdin;
1	1	3	2023-10-10 17:51:48.226733	2023-10-10 17:51:48.226733
2	1	4	2023-10-10 17:51:57.557931	2023-10-10 17:51:57.557931
3	1	7	2023-10-10 18:02:03.64635	2023-10-10 18:02:03.64635
4	1	8	2023-10-10 18:02:15.492486	2023-10-10 18:02:15.492486
5	1	9	2023-10-10 18:03:34.89865	2023-10-10 18:03:34.89865
6	1	10	2023-10-10 18:03:40.274608	2023-10-10 18:03:40.274608
7	2	3	2023-10-12 15:37:20.431503	2023-10-12 15:37:20.431503
8	2	8	2023-10-12 15:37:42.83575	2023-10-12 15:37:42.83575
9	2	9	2023-10-12 15:37:48.154733	2023-10-12 15:37:48.154733
10	2	10	2023-10-12 15:37:57.885085	2023-10-12 15:37:57.885085
\.


--
-- Name: film_attribute_types_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.film_attribute_types_id_seq', 3, true);


--
-- Name: film_attributes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.film_attributes_id_seq', 10, true);


--
-- Name: film_values_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.film_values_id_seq', 10, true);


--
-- Name: films_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.films_id_seq', 3, true);


--
-- Name: films_to_attributes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.films_to_attributes_id_seq', 10, true);


--
-- Name: film_attribute_types film_attribute_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film_attribute_types
    ADD CONSTRAINT film_attribute_types_pkey PRIMARY KEY (id);


--
-- Name: film_attributes film_attributes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film_attributes
    ADD CONSTRAINT film_attributes_pkey PRIMARY KEY (id);


--
-- Name: film_values film_values_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film_values
    ADD CONSTRAINT film_values_pkey PRIMARY KEY (id);


--
-- Name: films films_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.films
    ADD CONSTRAINT films_pkey PRIMARY KEY (id);


--
-- Name: films_to_attributes films_to_attributes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.films_to_attributes
    ADD CONSTRAINT films_to_attributes_pkey PRIMARY KEY (id);


--
-- Name: film_attributes film_attributes_type_fkey1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film_attributes
    ADD CONSTRAINT film_attributes_type_fkey1 FOREIGN KEY (film_attribute_type_id) REFERENCES public.film_attribute_types(id) ON DELETE SET NULL;


--
-- Name: film_values film_values_film_to_attribute_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film_values
    ADD CONSTRAINT film_values_film_to_attribute_id_fkey FOREIGN KEY (film_to_attribute_id) REFERENCES public.films_to_attributes(id) ON DELETE CASCADE;


--
-- Name: films_to_attributes films_to_attributes_film_attribute_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.films_to_attributes
    ADD CONSTRAINT films_to_attributes_film_attribute_id_fkey FOREIGN KEY (film_attribute_id) REFERENCES public.film_attributes(id) ON DELETE CASCADE;


--
-- Name: films_to_attributes films_to_attributes_film_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.films_to_attributes
    ADD CONSTRAINT films_to_attributes_film_id_fkey FOREIGN KEY (film_id) REFERENCES public.films(id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

