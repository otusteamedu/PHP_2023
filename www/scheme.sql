--
-- PostgreSQL database dump
--

-- Dumped from database version 16.1 (Debian 16.1-1.pgdg120+1)
-- Dumped by pg_dump version 16.1

-- Started on 2024-01-04 15:28:31 UTC

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
-- TOC entry 4 (class 2615 OID 2200)
-- Name: public; Type: SCHEMA; Schema: -; Owner: pg_database_owner
--

CREATE SCHEMA public;


ALTER SCHEMA public OWNER TO pg_database_owner;

--
-- TOC entry 3474 (class 0 OID 0)
-- Dependencies: 4
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: pg_database_owner
--

COMMENT ON SCHEMA public IS 'standard public schema';


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 238 (class 1259 OID 16514)
-- Name: attributes; Type: TABLE; Schema: public; Owner: sitemanager
--

CREATE TABLE public.attributes (
                                   id integer NOT NULL,
                                   name text NOT NULL,
                                   attribute_type_id integer NOT NULL
);


ALTER TABLE public.attributes OWNER TO sitemanager;

--
-- TOC entry 237 (class 1259 OID 16513)
-- Name: attributes_id_seq; Type: SEQUENCE; Schema: public; Owner: sitemanager
--

ALTER TABLE public.attributes ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.attributes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 236 (class 1259 OID 16506)
-- Name: attributes_type; Type: TABLE; Schema: public; Owner: sitemanager
--

CREATE TABLE public.attributes_type (
                                        id integer NOT NULL,
                                        name text NOT NULL
);


ALTER TABLE public.attributes_type OWNER TO sitemanager;

--
-- TOC entry 235 (class 1259 OID 16505)
-- Name: attributes_type_id_seq; Type: SEQUENCE; Schema: public; Owner: sitemanager
--

ALTER TABLE public.attributes_type ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.attributes_type_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 234 (class 1259 OID 16498)
-- Name: attributes_values; Type: TABLE; Schema: public; Owner: sitemanager
--

CREATE TABLE public.attributes_values (
                                          id integer NOT NULL,
                                          movie_id integer NOT NULL,
                                          attribute_id integer NOT NULL,
                                          val_text text,
                                          val_date date,
                                          val_num real,
                                          val_bool boolean,
                                          val_int integer,
                                          val_money money
);


ALTER TABLE public.attributes_values OWNER TO sitemanager;

--
-- TOC entry 233 (class 1259 OID 16497)
-- Name: attributes_values_id_seq; Type: SEQUENCE; Schema: public; Owner: sitemanager
--

ALTER TABLE public.attributes_values ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.attributes_values_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 216 (class 1259 OID 16395)
-- Name: genres; Type: TABLE; Schema: public; Owner: sitemanager
--

CREATE TABLE public.genres (
                               id integer NOT NULL,
                               name character(255)
);


ALTER TABLE public.genres OWNER TO sitemanager;

--
-- TOC entry 215 (class 1259 OID 16394)
-- Name: genres_id_seq; Type: SEQUENCE; Schema: public; Owner: sitemanager
--

ALTER TABLE public.genres ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.genres_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 218 (class 1259 OID 16401)
-- Name: halls; Type: TABLE; Schema: public; Owner: sitemanager
--

CREATE TABLE public.halls (
                              id integer NOT NULL,
                              name character(255) NOT NULL
);


ALTER TABLE public.halls OWNER TO sitemanager;

--
-- TOC entry 217 (class 1259 OID 16400)
-- Name: halls_id_seq; Type: SEQUENCE; Schema: public; Owner: sitemanager
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
-- TOC entry 220 (class 1259 OID 16407)
-- Name: movies; Type: TABLE; Schema: public; Owner: sitemanager
--

CREATE TABLE public.movies (
                               id integer NOT NULL,
                               name character(255) NOT NULL,
                               duration time without time zone NOT NULL,
                               release_date date
);


ALTER TABLE public.movies OWNER TO sitemanager;

--
-- TOC entry 222 (class 1259 OID 16420)
-- Name: movies_genres; Type: TABLE; Schema: public; Owner: sitemanager
--

CREATE TABLE public.movies_genres (
                                      id integer NOT NULL,
                                      movie_id integer NOT NULL,
                                      genre_id integer NOT NULL
);


ALTER TABLE public.movies_genres OWNER TO sitemanager;

--
-- TOC entry 221 (class 1259 OID 16419)
-- Name: movies_genres_id_seq; Type: SEQUENCE; Schema: public; Owner: sitemanager
--

ALTER TABLE public.movies_genres ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.movies_genres_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 219 (class 1259 OID 16406)
-- Name: movies_id_seq; Type: SEQUENCE; Schema: public; Owner: sitemanager
--

ALTER TABLE public.movies ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.movies_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 226 (class 1259 OID 16442)
-- Name: seat_map; Type: TABLE; Schema: public; Owner: sitemanager
--

CREATE TABLE public.seat_map (
                                 id integer NOT NULL,
                                 hall_id integer NOT NULL,
                                 seat_id integer NOT NULL
);


ALTER TABLE public.seat_map OWNER TO sitemanager;

--
-- TOC entry 225 (class 1259 OID 16441)
-- Name: seat_map_id_seq; Type: SEQUENCE; Schema: public; Owner: sitemanager
--

ALTER TABLE public.seat_map ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.seat_map_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 224 (class 1259 OID 16436)
-- Name: seats; Type: TABLE; Schema: public; Owner: sitemanager
--

CREATE TABLE public.seats (
                              id integer NOT NULL,
                              seat_number character(10) NOT NULL,
                              row_number integer NOT NULL
);


ALTER TABLE public.seats OWNER TO sitemanager;

--
-- TOC entry 223 (class 1259 OID 16435)
-- Name: seats_id_seq; Type: SEQUENCE; Schema: public; Owner: sitemanager
--

ALTER TABLE public.seats ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.seats_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 232 (class 1259 OID 16492)
-- Name: session_price; Type: TABLE; Schema: public; Owner: sitemanager
--

CREATE TABLE public.session_price (
                                      id integer NOT NULL,
                                      seat_map_id integer NOT NULL,
                                      session_id integer NOT NULL,
                                      price money NOT NULL
);


ALTER TABLE public.session_price OWNER TO sitemanager;

--
-- TOC entry 231 (class 1259 OID 16491)
-- Name: session_price_id_seq; Type: SEQUENCE; Schema: public; Owner: sitemanager
--

ALTER TABLE public.session_price ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.session_price_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 228 (class 1259 OID 16458)
-- Name: sessions; Type: TABLE; Schema: public; Owner: sitemanager
--

CREATE TABLE public.sessions (
                                 id integer NOT NULL,
                                 datetime timestamp without time zone NOT NULL,
                                 hall_id integer NOT NULL,
                                 movie_id integer NOT NULL
);


ALTER TABLE public.sessions OWNER TO sitemanager;

--
-- TOC entry 227 (class 1259 OID 16457)
-- Name: sessions_id_seq; Type: SEQUENCE; Schema: public; Owner: sitemanager
--

ALTER TABLE public.sessions ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.sessions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 230 (class 1259 OID 16474)
-- Name: tickets; Type: TABLE; Schema: public; Owner: sitemanager
--

CREATE TABLE public.tickets (
                                id integer NOT NULL,
                                session_id integer NOT NULL,
                                status character(255)[]
);


ALTER TABLE public.tickets OWNER TO sitemanager;

--
-- TOC entry 229 (class 1259 OID 16473)
-- Name: tickets_id_seq; Type: SEQUENCE; Schema: public; Owner: sitemanager
--

ALTER TABLE public.tickets ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.tickets_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 239 (class 1259 OID 16531)
-- Name: vw_marketing; Type: VIEW; Schema: public; Owner: sitemanager
--

CREATE VIEW public.vw_marketing AS
SELECT movies.name AS movie_name,
       concat('(', attributes_type.name, ')', ' ', attributes.name) AS attribute,
       COALESCE((attributes_values.val_num)::text, (attributes_values.val_money)::text, attributes_values.val_text) AS attr_val
FROM (((public.attributes_values
    LEFT JOIN public.movies ON ((movies.id = attributes_values.movie_id)))
    LEFT JOIN public.attributes ON ((attributes.id = attributes_values.attribute_id)))
    LEFT JOIN public.attributes_type ON ((attributes_type.id = attributes.attribute_type_id)))
ORDER BY attributes_type.name;


ALTER VIEW public.vw_marketing OWNER TO sitemanager;

--
-- TOC entry 240 (class 1259 OID 16550)
-- Name: vw_sessions_schedule; Type: VIEW; Schema: public; Owner: sitemanager
--

CREATE VIEW public.vw_sessions_schedule AS
WITH sessions_today AS (
    SELECT halls.name AS hall,
           movies.name AS movie_name,
           sessions.datetime
    FROM ((public.halls
        LEFT JOIN public.sessions ON ((halls.id = sessions.hall_id)))
        LEFT JOIN public.movies ON ((sessions.movie_id = movies.id)))
    WHERE ((sessions.datetime > '2024-01-04 00:00:00'::timestamp without time zone) AND (sessions.datetime < '2024-01-04 23:59:59'::timestamp without time zone))
), sessions_after_20_days AS (
    SELECT halls.name AS hall,
           movies.name AS movie_name,
           sessions.datetime
    FROM ((public.halls
        LEFT JOIN public.sessions ON ((halls.id = sessions.hall_id)))
        LEFT JOIN public.movies ON ((sessions.movie_id = movies.id)))
    WHERE ((sessions.datetime > ('2024-01-04 00:00:00'::timestamp without time zone + '20 days'::interval)) AND (sessions.datetime < ('2024-01-04 23:59:59'::timestamp without time zone + '20 days'::interval)))
)
SELECT sessions_today.hall,
       sessions_today.movie_name,
       sessions_today.datetime AS session_today_time,
       sessions_after_20_days.datetime AS session_after_20_days_time
FROM (sessions_today
    LEFT JOIN sessions_after_20_days ON (((sessions_today.hall = sessions_after_20_days.hall) AND (sessions_today.movie_name = sessions_after_20_days.movie_name))))
ORDER BY sessions_today.datetime;


ALTER VIEW public.vw_sessions_schedule OWNER TO sitemanager;

--
-- TOC entry 3468 (class 0 OID 16514)
-- Dependencies: 238
-- Data for Name: attributes; Type: TABLE DATA; Schema: public; Owner: sitemanager
--

COPY public.attributes (id, name, attribute_type_id) FROM stdin;
1	рецензии критиков	2
2	отзыв кинопоиск	2
3	отзыв IMDb	2
4	рейтинг кинопоиск	8
5	рейтинг IMDb	8
6	премия оскар	4
7	премия ника	4
8	мировая премьера	6
9	премьера в РФ	6
10	начала продажи билетов	6
11	запуск рекламы на TВ	5
12	cлоган	1
13	бюджет	8
14	возраст	7
\.


--
-- TOC entry 3466 (class 0 OID 16506)
-- Dependencies: 236
-- Data for Name: attributes_type; Type: TABLE DATA; Schema: public; Owner: sitemanager
--

COPY public.attributes_type (id, name) FROM stdin;
1	string
2	text
3	image
4	boolean
5	datetime
6	date
7	integer
8	float
\.


--
-- TOC entry 3464 (class 0 OID 16498)
-- Dependencies: 234
-- Data for Name: attributes_values; Type: TABLE DATA; Schema: public; Owner: sitemanager
--

COPY public.attributes_values (id, movie_id, attribute_id, val_text, val_date, val_num, val_bool, val_int, val_money) FROM stdin;
1	2	4	\N	\N	8.8	\N	\N	\N
2	2	12	«Sometimes you have to reach into someone else's world to find out what's missing in your own»	\N	\N	\N	\N	\N
3	3	4	\N	\N	8	\N	\N	\N
4	3	12	«Earn. Spend. Party»	\N	\N	\N	\N	\N
\.


--
-- TOC entry 3446 (class 0 OID 16395)
-- Dependencies: 216
-- Data for Name: genres; Type: TABLE DATA; Schema: public; Owner: sitemanager
--

COPY public.genres (id, name) FROM stdin;
1	драма
2	комедия
3	биография
4	криминал
\.


--
-- TOC entry 3448 (class 0 OID 16401)
-- Dependencies: 218
-- Data for Name: halls; Type: TABLE DATA; Schema: public; Owner: sitemanager
--

COPY public.halls (id, name) FROM stdin;
1	3D
2	2D
\.


--
-- TOC entry 3450 (class 0 OID 16407)
-- Dependencies: 220
-- Data for Name: movies; Type: TABLE DATA; Schema: public; Owner: sitemanager
--

COPY public.movies (id, name, duration, release_date) FROM stdin;
2	1+1                                                                                                                                                                                                                                                            	01:52:00	2012-04-26
3	Волк с Уолл-стрит                                                                                                                                                                                                                                              	03:00:00	2013-12-17
\.


--
-- TOC entry 3452 (class 0 OID 16420)
-- Dependencies: 222
-- Data for Name: movies_genres; Type: TABLE DATA; Schema: public; Owner: sitemanager
--

COPY public.movies_genres (id, movie_id, genre_id) FROM stdin;
2	2	1
3	2	2
4	2	3
5	3	1
6	3	2
7	3	3
8	3	4
\.


--
-- TOC entry 3456 (class 0 OID 16442)
-- Dependencies: 226
-- Data for Name: seat_map; Type: TABLE DATA; Schema: public; Owner: sitemanager
--

COPY public.seat_map (id, hall_id, seat_id) FROM stdin;
1	1	1
2	1	2
3	1	3
4	1	4
5	2	1
6	2	2
7	2	3
8	2	4
\.


--
-- TOC entry 3454 (class 0 OID 16436)
-- Dependencies: 224
-- Data for Name: seats; Type: TABLE DATA; Schema: public; Owner: sitemanager
--

COPY public.seats (id, seat_number, row_number) FROM stdin;
1	A1        	1
2	A2        	1
3	B1        	2
4	B2        	2
\.


--
-- TOC entry 3462 (class 0 OID 16492)
-- Dependencies: 232
-- Data for Name: session_price; Type: TABLE DATA; Schema: public; Owner: sitemanager
--

COPY public.session_price (id, seat_map_id, session_id, price) FROM stdin;
1	1	1	$200.00
2	2	1	$150.00
\.


--
-- TOC entry 3458 (class 0 OID 16458)
-- Dependencies: 228
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: sitemanager
--

COPY public.sessions (id, datetime, hall_id, movie_id) FROM stdin;
1	2024-01-04 14:30:00	1	2
2	2024-01-02 14:30:00	2	3
3	2024-01-24 14:30:00	1	2
\.


--
-- TOC entry 3460 (class 0 OID 16474)
-- Dependencies: 230
-- Data for Name: tickets; Type: TABLE DATA; Schema: public; Owner: sitemanager
--

COPY public.tickets (id, session_id, status) FROM stdin;
1	1	{"reserved                                                                                                                                                                                                                                                       "}
2	2	{"sold                                                                                                                                                                                                                                                           "}
\.


--
-- TOC entry 3475 (class 0 OID 0)
-- Dependencies: 237
-- Name: attributes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sitemanager
--

SELECT pg_catalog.setval('public.attributes_id_seq', 14, true);


--
-- TOC entry 3476 (class 0 OID 0)
-- Dependencies: 235
-- Name: attributes_type_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sitemanager
--

SELECT pg_catalog.setval('public.attributes_type_id_seq', 8, true);


--
-- TOC entry 3477 (class 0 OID 0)
-- Dependencies: 233
-- Name: attributes_values_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sitemanager
--

SELECT pg_catalog.setval('public.attributes_values_id_seq', 4, true);


--
-- TOC entry 3478 (class 0 OID 0)
-- Dependencies: 215
-- Name: genres_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sitemanager
--

SELECT pg_catalog.setval('public.genres_id_seq', 4, true);


--
-- TOC entry 3479 (class 0 OID 0)
-- Dependencies: 217
-- Name: halls_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sitemanager
--

SELECT pg_catalog.setval('public.halls_id_seq', 2, true);


--
-- TOC entry 3480 (class 0 OID 0)
-- Dependencies: 221
-- Name: movies_genres_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sitemanager
--

SELECT pg_catalog.setval('public.movies_genres_id_seq', 8, true);


--
-- TOC entry 3481 (class 0 OID 0)
-- Dependencies: 219
-- Name: movies_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sitemanager
--

SELECT pg_catalog.setval('public.movies_id_seq', 3, true);


--
-- TOC entry 3482 (class 0 OID 0)
-- Dependencies: 225
-- Name: seat_map_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sitemanager
--

SELECT pg_catalog.setval('public.seat_map_id_seq', 8, true);


--
-- TOC entry 3483 (class 0 OID 0)
-- Dependencies: 223
-- Name: seats_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sitemanager
--

SELECT pg_catalog.setval('public.seats_id_seq', 4, true);


--
-- TOC entry 3484 (class 0 OID 0)
-- Dependencies: 231
-- Name: session_price_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sitemanager
--

SELECT pg_catalog.setval('public.session_price_id_seq', 2, true);


--
-- TOC entry 3485 (class 0 OID 0)
-- Dependencies: 227
-- Name: sessions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sitemanager
--

SELECT pg_catalog.setval('public.sessions_id_seq', 3, true);


--
-- TOC entry 3486 (class 0 OID 0)
-- Dependencies: 229
-- Name: tickets_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sitemanager
--

SELECT pg_catalog.setval('public.tickets_id_seq', 2, true);


--
-- TOC entry 3289 (class 2606 OID 16520)
-- Name: attributes attributes_pkey; Type: CONSTRAINT; Schema: public; Owner: sitemanager
--

ALTER TABLE ONLY public.attributes
    ADD CONSTRAINT attributes_pkey PRIMARY KEY (id);


--
-- TOC entry 3287 (class 2606 OID 16512)
-- Name: attributes_type attributes_type_pkey; Type: CONSTRAINT; Schema: public; Owner: sitemanager
--

ALTER TABLE ONLY public.attributes_type
    ADD CONSTRAINT attributes_type_pkey PRIMARY KEY (id);


--
-- TOC entry 3285 (class 2606 OID 16504)
-- Name: attributes_values attributes_values_pkey; Type: CONSTRAINT; Schema: public; Owner: sitemanager
--

ALTER TABLE ONLY public.attributes_values
    ADD CONSTRAINT attributes_values_pkey PRIMARY KEY (id);


--
-- TOC entry 3267 (class 2606 OID 16399)
-- Name: genres genres_pkey; Type: CONSTRAINT; Schema: public; Owner: sitemanager
--

ALTER TABLE ONLY public.genres
    ADD CONSTRAINT genres_pkey PRIMARY KEY (id);


--
-- TOC entry 3269 (class 2606 OID 16405)
-- Name: halls halls_pkey; Type: CONSTRAINT; Schema: public; Owner: sitemanager
--

ALTER TABLE ONLY public.halls
    ADD CONSTRAINT halls_pkey PRIMARY KEY (id);


--
-- TOC entry 3273 (class 2606 OID 16424)
-- Name: movies_genres movies_genres_pkey; Type: CONSTRAINT; Schema: public; Owner: sitemanager
--

ALTER TABLE ONLY public.movies_genres
    ADD CONSTRAINT movies_genres_pkey PRIMARY KEY (id);


--
-- TOC entry 3271 (class 2606 OID 16411)
-- Name: movies movies_pkey; Type: CONSTRAINT; Schema: public; Owner: sitemanager
--

ALTER TABLE ONLY public.movies
    ADD CONSTRAINT movies_pkey PRIMARY KEY (id);


--
-- TOC entry 3277 (class 2606 OID 16446)
-- Name: seat_map seat_map_pkey; Type: CONSTRAINT; Schema: public; Owner: sitemanager
--

ALTER TABLE ONLY public.seat_map
    ADD CONSTRAINT seat_map_pkey PRIMARY KEY (id);


--
-- TOC entry 3275 (class 2606 OID 16440)
-- Name: seats seats_pkey; Type: CONSTRAINT; Schema: public; Owner: sitemanager
--

ALTER TABLE ONLY public.seats
    ADD CONSTRAINT seats_pkey PRIMARY KEY (id);


--
-- TOC entry 3283 (class 2606 OID 16496)
-- Name: session_price session_price_pkey; Type: CONSTRAINT; Schema: public; Owner: sitemanager
--

ALTER TABLE ONLY public.session_price
    ADD CONSTRAINT session_price_pkey PRIMARY KEY (id);


--
-- TOC entry 3279 (class 2606 OID 16462)
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: sitemanager
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- TOC entry 3281 (class 2606 OID 16480)
-- Name: tickets tickets_pkey; Type: CONSTRAINT; Schema: public; Owner: sitemanager
--

ALTER TABLE ONLY public.tickets
    ADD CONSTRAINT tickets_pkey PRIMARY KEY (id);


--
-- TOC entry 3299 (class 2606 OID 16521)
-- Name: attributes attributes_attribute_type_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: sitemanager
--

ALTER TABLE ONLY public.attributes
    ADD CONSTRAINT attributes_attribute_type_id_fkey FOREIGN KEY (attribute_type_id) REFERENCES public.attributes_type(id);


--
-- TOC entry 3297 (class 2606 OID 16526)
-- Name: attributes_values attributes_values_attribute_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: sitemanager
--

ALTER TABLE ONLY public.attributes_values
    ADD CONSTRAINT attributes_values_attribute_id_fkey FOREIGN KEY (attribute_id) REFERENCES public.attributes(id) NOT VALID;


--
-- TOC entry 3298 (class 2606 OID 16536)
-- Name: attributes_values attributes_values_movie_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: sitemanager
--

ALTER TABLE ONLY public.attributes_values
    ADD CONSTRAINT attributes_values_movie_id_fkey FOREIGN KEY (movie_id) REFERENCES public.movies(id) NOT VALID;


--
-- TOC entry 3290 (class 2606 OID 16430)
-- Name: movies_genres movies_genres_genre_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: sitemanager
--

ALTER TABLE ONLY public.movies_genres
    ADD CONSTRAINT movies_genres_genre_id_fkey FOREIGN KEY (genre_id) REFERENCES public.genres(id);


--
-- TOC entry 3291 (class 2606 OID 16425)
-- Name: movies_genres movies_genres_movie_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: sitemanager
--

ALTER TABLE ONLY public.movies_genres
    ADD CONSTRAINT movies_genres_movie_id_fkey FOREIGN KEY (movie_id) REFERENCES public.movies(id);


--
-- TOC entry 3292 (class 2606 OID 16447)
-- Name: seat_map seat_map_hall_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: sitemanager
--

ALTER TABLE ONLY public.seat_map
    ADD CONSTRAINT seat_map_hall_id_fkey FOREIGN KEY (hall_id) REFERENCES public.halls(id);


--
-- TOC entry 3293 (class 2606 OID 16452)
-- Name: seat_map seat_map_seat_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: sitemanager
--

ALTER TABLE ONLY public.seat_map
    ADD CONSTRAINT seat_map_seat_id_fkey FOREIGN KEY (seat_id) REFERENCES public.seats(id);


--
-- TOC entry 3294 (class 2606 OID 16463)
-- Name: sessions sessions_hall_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: sitemanager
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_hall_id_fkey FOREIGN KEY (hall_id) REFERENCES public.halls(id);


--
-- TOC entry 3295 (class 2606 OID 16468)
-- Name: sessions sessions_movie_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: sitemanager
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_movie_id_fkey FOREIGN KEY (movie_id) REFERENCES public.movies(id);


--
-- TOC entry 3296 (class 2606 OID 16481)
-- Name: tickets tickets_session_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: sitemanager
--

ALTER TABLE ONLY public.tickets
    ADD CONSTRAINT tickets_session_id_fkey FOREIGN KEY (session_id) REFERENCES public.sessions(id) NOT VALID;


-- Completed on 2024-01-04 15:28:32 UTC

--
-- PostgreSQL database dump complete
--

