--
-- PostgreSQL database dump
--

-- Dumped from database version 16.1 (Debian 16.1-1.pgdg120+1)
-- Dumped by pg_dump version 16.1

-- Started on 2024-01-03 16:29:54 UTC

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
-- TOC entry 3435 (class 0 OID 0)
-- Dependencies: 4
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: pg_database_owner
--

COMMENT ON SCHEMA public IS 'standard public schema';


SET default_tablespace = '';

SET default_table_access_method = heap;

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
                                status character(255)[],
                                seat_map_id integer
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
-- TOC entry 3413 (class 0 OID 16395)
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
-- TOC entry 3415 (class 0 OID 16401)
-- Dependencies: 218
-- Data for Name: halls; Type: TABLE DATA; Schema: public; Owner: sitemanager
--

COPY public.halls (id, name) FROM stdin;
1	3D
2	2D
\.


--
-- TOC entry 3417 (class 0 OID 16407)
-- Dependencies: 220
-- Data for Name: movies; Type: TABLE DATA; Schema: public; Owner: sitemanager
--

COPY public.movies (id, name, duration, release_date) FROM stdin;
2	1+1                                                                                                                                                                                                                                                            	01:52:00	2012-04-26
3	Волк с Уолл-стрит                                                                                                                                                                                                                                              	03:00:00	2013-12-17
\.


--
-- TOC entry 3419 (class 0 OID 16420)
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
-- TOC entry 3423 (class 0 OID 16442)
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
-- TOC entry 3421 (class 0 OID 16436)
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
-- TOC entry 3429 (class 0 OID 16492)
-- Dependencies: 232
-- Data for Name: session_price; Type: TABLE DATA; Schema: public; Owner: sitemanager
--

COPY public.session_price (id, seat_map_id, session_id, price) FROM stdin;
1	1	1	$200.00
2	2	1	$150.00
\.


--
-- TOC entry 3425 (class 0 OID 16458)
-- Dependencies: 228
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: sitemanager
--

COPY public.sessions (id, datetime, hall_id, movie_id) FROM stdin;
1	2023-01-01 14:30:00	1	2
2	2023-01-02 14:30:00	2	3
\.


--
-- TOC entry 3427 (class 0 OID 16474)
-- Dependencies: 230
-- Data for Name: tickets; Type: TABLE DATA; Schema: public; Owner: sitemanager
--

COPY public.tickets (id, session_id, status, seat_map_id) FROM stdin;
1	1	{"reserved                                                                                                                                                                                                                                                       "}	1
2	2	{"sold                                                                                                                                                                                                                                                           "}	2
\.


--
-- TOC entry 3436 (class 0 OID 0)
-- Dependencies: 215
-- Name: genres_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sitemanager
--

SELECT pg_catalog.setval('public.genres_id_seq', 4, true);


--
-- TOC entry 3437 (class 0 OID 0)
-- Dependencies: 217
-- Name: halls_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sitemanager
--

SELECT pg_catalog.setval('public.halls_id_seq', 2, true);


--
-- TOC entry 3438 (class 0 OID 0)
-- Dependencies: 221
-- Name: movies_genres_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sitemanager
--

SELECT pg_catalog.setval('public.movies_genres_id_seq', 8, true);


--
-- TOC entry 3439 (class 0 OID 0)
-- Dependencies: 219
-- Name: movies_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sitemanager
--

SELECT pg_catalog.setval('public.movies_id_seq', 3, true);


--
-- TOC entry 3440 (class 0 OID 0)
-- Dependencies: 225
-- Name: seat_map_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sitemanager
--

SELECT pg_catalog.setval('public.seat_map_id_seq', 8, true);


--
-- TOC entry 3441 (class 0 OID 0)
-- Dependencies: 223
-- Name: seats_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sitemanager
--

SELECT pg_catalog.setval('public.seats_id_seq', 4, true);


--
-- TOC entry 3442 (class 0 OID 0)
-- Dependencies: 231
-- Name: session_price_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sitemanager
--

SELECT pg_catalog.setval('public.session_price_id_seq', 2, true);


--
-- TOC entry 3443 (class 0 OID 0)
-- Dependencies: 227
-- Name: sessions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sitemanager
--

SELECT pg_catalog.setval('public.sessions_id_seq', 2, true);


--
-- TOC entry 3444 (class 0 OID 0)
-- Dependencies: 229
-- Name: tickets_id_seq; Type: SEQUENCE SET; Schema: public; Owner: sitemanager
--

SELECT pg_catalog.setval('public.tickets_id_seq', 2, true);


--
-- TOC entry 3244 (class 2606 OID 16399)
-- Name: genres genres_pkey; Type: CONSTRAINT; Schema: public; Owner: sitemanager
--

ALTER TABLE ONLY public.genres
    ADD CONSTRAINT genres_pkey PRIMARY KEY (id);


--
-- TOC entry 3246 (class 2606 OID 16405)
-- Name: halls halls_pkey; Type: CONSTRAINT; Schema: public; Owner: sitemanager
--

ALTER TABLE ONLY public.halls
    ADD CONSTRAINT halls_pkey PRIMARY KEY (id);


--
-- TOC entry 3250 (class 2606 OID 16424)
-- Name: movies_genres movies_genres_pkey; Type: CONSTRAINT; Schema: public; Owner: sitemanager
--

ALTER TABLE ONLY public.movies_genres
    ADD CONSTRAINT movies_genres_pkey PRIMARY KEY (id);


--
-- TOC entry 3248 (class 2606 OID 16411)
-- Name: movies movies_pkey; Type: CONSTRAINT; Schema: public; Owner: sitemanager
--

ALTER TABLE ONLY public.movies
    ADD CONSTRAINT movies_pkey PRIMARY KEY (id);


--
-- TOC entry 3254 (class 2606 OID 16446)
-- Name: seat_map seat_map_pkey; Type: CONSTRAINT; Schema: public; Owner: sitemanager
--

ALTER TABLE ONLY public.seat_map
    ADD CONSTRAINT seat_map_pkey PRIMARY KEY (id);


--
-- TOC entry 3252 (class 2606 OID 16440)
-- Name: seats seats_pkey; Type: CONSTRAINT; Schema: public; Owner: sitemanager
--

ALTER TABLE ONLY public.seats
    ADD CONSTRAINT seats_pkey PRIMARY KEY (id);


--
-- TOC entry 3260 (class 2606 OID 16496)
-- Name: session_price session_price_pkey; Type: CONSTRAINT; Schema: public; Owner: sitemanager
--

ALTER TABLE ONLY public.session_price
    ADD CONSTRAINT session_price_pkey PRIMARY KEY (id);


--
-- TOC entry 3256 (class 2606 OID 16462)
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: sitemanager
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- TOC entry 3258 (class 2606 OID 16480)
-- Name: tickets tickets_pkey; Type: CONSTRAINT; Schema: public; Owner: sitemanager
--

ALTER TABLE ONLY public.tickets
    ADD CONSTRAINT tickets_pkey PRIMARY KEY (id);


--
-- TOC entry 3261 (class 2606 OID 16430)
-- Name: movies_genres movies_genres_genre_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: sitemanager
--

ALTER TABLE ONLY public.movies_genres
    ADD CONSTRAINT movies_genres_genre_id_fkey FOREIGN KEY (genre_id) REFERENCES public.genres(id);


--
-- TOC entry 3262 (class 2606 OID 16425)
-- Name: movies_genres movies_genres_movie_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: sitemanager
--

ALTER TABLE ONLY public.movies_genres
    ADD CONSTRAINT movies_genres_movie_id_fkey FOREIGN KEY (movie_id) REFERENCES public.movies(id);


--
-- TOC entry 3263 (class 2606 OID 16447)
-- Name: seat_map seat_map_hall_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: sitemanager
--

ALTER TABLE ONLY public.seat_map
    ADD CONSTRAINT seat_map_hall_id_fkey FOREIGN KEY (hall_id) REFERENCES public.halls(id);


--
-- TOC entry 3264 (class 2606 OID 16452)
-- Name: seat_map seat_map_seat_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: sitemanager
--

ALTER TABLE ONLY public.seat_map
    ADD CONSTRAINT seat_map_seat_id_fkey FOREIGN KEY (seat_id) REFERENCES public.seats(id);


--
-- TOC entry 3265 (class 2606 OID 16463)
-- Name: sessions sessions_hall_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: sitemanager
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_hall_id_fkey FOREIGN KEY (hall_id) REFERENCES public.halls(id);


--
-- TOC entry 3266 (class 2606 OID 16468)
-- Name: sessions sessions_movie_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: sitemanager
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_movie_id_fkey FOREIGN KEY (movie_id) REFERENCES public.movies(id);


--
-- TOC entry 3267 (class 2606 OID 16486)
-- Name: tickets tickets_seat_map_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: sitemanager
--

ALTER TABLE ONLY public.tickets
    ADD CONSTRAINT tickets_seat_map_id_fkey FOREIGN KEY (seat_map_id) REFERENCES public.seat_map(id) NOT VALID;


--
-- TOC entry 3268 (class 2606 OID 16481)
-- Name: tickets tickets_session_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: sitemanager
--

ALTER TABLE ONLY public.tickets
    ADD CONSTRAINT tickets_session_id_fkey FOREIGN KEY (session_id) REFERENCES public.sessions(id) NOT VALID;


-- Completed on 2024-01-03 16:29:54 UTC

--
-- PostgreSQL database dump complete
--

