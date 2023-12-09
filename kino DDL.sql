--
-- PostgreSQL database dump
--

-- Dumped from database version 12.12
-- Dumped by pg_dump version 12.12

-- Started on 2023-12-09 11:40:16

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
-- TOC entry 2908 (class 1262 OID 16393)
-- Name: kino; Type: DATABASE; Schema: -; Owner: postgres
--

CREATE DATABASE kino WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'Russian_Russia.1251' LC_CTYPE = 'Russian_Russia.1251';


ALTER DATABASE kino OWNER TO postgres;

\connect kino

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
-- TOC entry 224 (class 1259 OID 16539)
-- Name: tickets; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tickets (
    uid bigint NOT NULL,
    session_id bigint NOT NULL,
    place_id bigint NOT NULL,
    place_price integer NOT NULL
);


ALTER TABLE public.tickets OWNER TO postgres;

--
-- TOC entry 223 (class 1259 OID 16537)
-- Name: Tickets_place_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public."Tickets_place_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Tickets_place_id_seq" OWNER TO postgres;

--
-- TOC entry 2909 (class 0 OID 0)
-- Dependencies: 223
-- Name: Tickets_place_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public."Tickets_place_id_seq" OWNED BY public.tickets.place_id;


--
-- TOC entry 222 (class 1259 OID 16535)
-- Name: Tickets_session_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public."Tickets_session_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Tickets_session_id_seq" OWNER TO postgres;

--
-- TOC entry 2910 (class 0 OID 0)
-- Dependencies: 222
-- Name: Tickets_session_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public."Tickets_session_id_seq" OWNED BY public.tickets.session_id;


--
-- TOC entry 221 (class 1259 OID 16533)
-- Name: Tickets_uid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public."Tickets_uid_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."Tickets_uid_seq" OWNER TO postgres;

--
-- TOC entry 2911 (class 0 OID 0)
-- Dependencies: 221
-- Name: Tickets_uid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public."Tickets_uid_seq" OWNED BY public.tickets.uid;


--
-- TOC entry 205 (class 1259 OID 16434)
-- Name: halls; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.halls (
    uid bigint NOT NULL,
    hall_name character varying NOT NULL
);


ALTER TABLE public.halls OWNER TO postgres;

--
-- TOC entry 204 (class 1259 OID 16432)
-- Name: halls_uid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.halls_uid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.halls_uid_seq OWNER TO postgres;

--
-- TOC entry 2912 (class 0 OID 0)
-- Dependencies: 204
-- Name: halls_uid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.halls_uid_seq OWNED BY public.halls.uid;


--
-- TOC entry 210 (class 1259 OID 16461)
-- Name: movie_categories; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.movie_categories (
    uid bigint NOT NULL,
    category_name character varying NOT NULL,
    date_start date NOT NULL,
    date_end date
);


ALTER TABLE public.movie_categories OWNER TO postgres;

--
-- TOC entry 209 (class 1259 OID 16459)
-- Name: movie_categories_uid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.movie_categories_uid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.movie_categories_uid_seq OWNER TO postgres;

--
-- TOC entry 2913 (class 0 OID 0)
-- Dependencies: 209
-- Name: movie_categories_uid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.movie_categories_uid_seq OWNED BY public.movie_categories.uid;


--
-- TOC entry 216 (class 1259 OID 16490)
-- Name: movies; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.movies (
    uid bigint NOT NULL,
    movie_category_id bigint NOT NULL,
    movie_name character varying NOT NULL,
    movie_duration integer,
    date_screen_start date,
    date_screen_end date
);


ALTER TABLE public.movies OWNER TO postgres;

--
-- TOC entry 215 (class 1259 OID 16488)
-- Name: movies_movie_category_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.movies_movie_category_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.movies_movie_category_id_seq OWNER TO postgres;

--
-- TOC entry 2914 (class 0 OID 0)
-- Dependencies: 215
-- Name: movies_movie_category_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.movies_movie_category_id_seq OWNED BY public.movies.movie_category_id;


--
-- TOC entry 214 (class 1259 OID 16486)
-- Name: movies_uid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.movies_uid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.movies_uid_seq OWNER TO postgres;

--
-- TOC entry 2915 (class 0 OID 0)
-- Dependencies: 214
-- Name: movies_uid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.movies_uid_seq OWNED BY public.movies.uid;


--
-- TOC entry 208 (class 1259 OID 16447)
-- Name: places; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.places (
    uid bigint NOT NULL,
    hall_id bigint NOT NULL,
    place_number integer NOT NULL,
    "row" integer NOT NULL
);


ALTER TABLE public.places OWNER TO postgres;

--
-- TOC entry 207 (class 1259 OID 16445)
-- Name: places_hall_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.places_hall_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.places_hall_id_seq OWNER TO postgres;

--
-- TOC entry 2916 (class 0 OID 0)
-- Dependencies: 207
-- Name: places_hall_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.places_hall_id_seq OWNED BY public.places.hall_id;


--
-- TOC entry 206 (class 1259 OID 16443)
-- Name: places_uid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.places_uid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.places_uid_seq OWNER TO postgres;

--
-- TOC entry 2917 (class 0 OID 0)
-- Dependencies: 206
-- Name: places_uid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.places_uid_seq OWNED BY public.places.uid;


--
-- TOC entry 213 (class 1259 OID 16472)
-- Name: price_categories; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.price_categories (
    uid bigint NOT NULL,
    movie_category_id bigint NOT NULL,
    time_start time without time zone NOT NULL,
    time_end time without time zone NOT NULL,
    price integer NOT NULL
);


ALTER TABLE public.price_categories OWNER TO postgres;

--
-- TOC entry 212 (class 1259 OID 16470)
-- Name: price_categories_category_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.price_categories_category_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.price_categories_category_id_seq OWNER TO postgres;

--
-- TOC entry 2918 (class 0 OID 0)
-- Dependencies: 212
-- Name: price_categories_category_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.price_categories_category_id_seq OWNED BY public.price_categories.movie_category_id;


--
-- TOC entry 211 (class 1259 OID 16468)
-- Name: price_categories_uid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.price_categories_uid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.price_categories_uid_seq OWNER TO postgres;

--
-- TOC entry 2919 (class 0 OID 0)
-- Dependencies: 211
-- Name: price_categories_uid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.price_categories_uid_seq OWNED BY public.price_categories.uid;


--
-- TOC entry 220 (class 1259 OID 16515)
-- Name: shelude_sessions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.shelude_sessions (
    uid bigint NOT NULL,
    movie_id bigint NOT NULL,
    hall_id bigint NOT NULL,
    screen_time_start time without time zone,
    screen_time_end time without time zone,
    summ integer NOT NULL
);


ALTER TABLE public.shelude_sessions OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 16513)
-- Name: shelude_sessions_hall_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.shelude_sessions_hall_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.shelude_sessions_hall_id_seq OWNER TO postgres;

--
-- TOC entry 2920 (class 0 OID 0)
-- Dependencies: 219
-- Name: shelude_sessions_hall_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.shelude_sessions_hall_id_seq OWNED BY public.shelude_sessions.hall_id;


--
-- TOC entry 218 (class 1259 OID 16511)
-- Name: shelude_sessions_movie_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.shelude_sessions_movie_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.shelude_sessions_movie_id_seq OWNER TO postgres;

--
-- TOC entry 2921 (class 0 OID 0)
-- Dependencies: 218
-- Name: shelude_sessions_movie_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.shelude_sessions_movie_id_seq OWNED BY public.shelude_sessions.movie_id;


--
-- TOC entry 217 (class 1259 OID 16509)
-- Name: shelude_sessions_uid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.shelude_sessions_uid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.shelude_sessions_uid_seq OWNER TO postgres;

--
-- TOC entry 2922 (class 0 OID 0)
-- Dependencies: 217
-- Name: shelude_sessions_uid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.shelude_sessions_uid_seq OWNED BY public.shelude_sessions.uid;


--
-- TOC entry 2742 (class 2604 OID 16437)
-- Name: halls uid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.halls ALTER COLUMN uid SET DEFAULT nextval('public.halls_uid_seq'::regclass);


--
-- TOC entry 2745 (class 2604 OID 16464)
-- Name: movie_categories uid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.movie_categories ALTER COLUMN uid SET DEFAULT nextval('public.movie_categories_uid_seq'::regclass);


--
-- TOC entry 2748 (class 2604 OID 16493)
-- Name: movies uid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.movies ALTER COLUMN uid SET DEFAULT nextval('public.movies_uid_seq'::regclass);


--
-- TOC entry 2749 (class 2604 OID 16494)
-- Name: movies movie_category_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.movies ALTER COLUMN movie_category_id SET DEFAULT nextval('public.movies_movie_category_id_seq'::regclass);


--
-- TOC entry 2743 (class 2604 OID 16450)
-- Name: places uid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.places ALTER COLUMN uid SET DEFAULT nextval('public.places_uid_seq'::regclass);


--
-- TOC entry 2744 (class 2604 OID 16451)
-- Name: places hall_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.places ALTER COLUMN hall_id SET DEFAULT nextval('public.places_hall_id_seq'::regclass);


--
-- TOC entry 2746 (class 2604 OID 16475)
-- Name: price_categories uid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.price_categories ALTER COLUMN uid SET DEFAULT nextval('public.price_categories_uid_seq'::regclass);


--
-- TOC entry 2747 (class 2604 OID 16476)
-- Name: price_categories movie_category_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.price_categories ALTER COLUMN movie_category_id SET DEFAULT nextval('public.price_categories_category_id_seq'::regclass);


--
-- TOC entry 2750 (class 2604 OID 16518)
-- Name: shelude_sessions uid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.shelude_sessions ALTER COLUMN uid SET DEFAULT nextval('public.shelude_sessions_uid_seq'::regclass);


--
-- TOC entry 2751 (class 2604 OID 16519)
-- Name: shelude_sessions movie_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.shelude_sessions ALTER COLUMN movie_id SET DEFAULT nextval('public.shelude_sessions_movie_id_seq'::regclass);


--
-- TOC entry 2752 (class 2604 OID 16520)
-- Name: shelude_sessions hall_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.shelude_sessions ALTER COLUMN hall_id SET DEFAULT nextval('public.shelude_sessions_hall_id_seq'::regclass);


--
-- TOC entry 2753 (class 2604 OID 16542)
-- Name: tickets uid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tickets ALTER COLUMN uid SET DEFAULT nextval('public."Tickets_uid_seq"'::regclass);


--
-- TOC entry 2754 (class 2604 OID 16543)
-- Name: tickets session_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tickets ALTER COLUMN session_id SET DEFAULT nextval('public."Tickets_session_id_seq"'::regclass);


--
-- TOC entry 2755 (class 2604 OID 16544)
-- Name: tickets place_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tickets ALTER COLUMN place_id SET DEFAULT nextval('public."Tickets_place_id_seq"'::regclass);


--
-- TOC entry 2769 (class 2606 OID 16546)
-- Name: tickets Tickets_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tickets
    ADD CONSTRAINT "Tickets_pkey" PRIMARY KEY (uid);


--
-- TOC entry 2757 (class 2606 OID 16442)
-- Name: halls halls_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.halls
    ADD CONSTRAINT halls_pkey PRIMARY KEY (uid);


--
-- TOC entry 2761 (class 2606 OID 16478)
-- Name: movie_categories movie_categories_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.movie_categories
    ADD CONSTRAINT movie_categories_pkey PRIMARY KEY (uid);


--
-- TOC entry 2765 (class 2606 OID 16499)
-- Name: movies movies_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.movies
    ADD CONSTRAINT movies_pkey PRIMARY KEY (uid);


--
-- TOC entry 2759 (class 2606 OID 16453)
-- Name: places places_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.places
    ADD CONSTRAINT places_pkey PRIMARY KEY (uid);


--
-- TOC entry 2763 (class 2606 OID 16480)
-- Name: price_categories price_categories_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.price_categories
    ADD CONSTRAINT price_categories_pkey PRIMARY KEY (uid);


--
-- TOC entry 2767 (class 2606 OID 16522)
-- Name: shelude_sessions shelude_sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.shelude_sessions
    ADD CONSTRAINT shelude_sessions_pkey PRIMARY KEY (uid);


--
-- TOC entry 2776 (class 2606 OID 16552)
-- Name: tickets FK_Tickets_places; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tickets
    ADD CONSTRAINT "FK_Tickets_places" FOREIGN KEY (place_id) REFERENCES public.places(uid);


--
-- TOC entry 2775 (class 2606 OID 16547)
-- Name: tickets FK_Tickets_shelude_sessions; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tickets
    ADD CONSTRAINT "FK_Tickets_shelude_sessions" FOREIGN KEY (session_id) REFERENCES public.shelude_sessions(uid);


--
-- TOC entry 2772 (class 2606 OID 16500)
-- Name: movies FK__movie_categories; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.movies
    ADD CONSTRAINT "FK__movie_categories" FOREIGN KEY (movie_category_id) REFERENCES public.movie_categories(uid);


--
-- TOC entry 2770 (class 2606 OID 16454)
-- Name: places FK_places_halls; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.places
    ADD CONSTRAINT "FK_places_halls" FOREIGN KEY (hall_id) REFERENCES public.halls(uid);


--
-- TOC entry 2771 (class 2606 OID 16481)
-- Name: price_categories FK_price_categories_movie_categories; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.price_categories
    ADD CONSTRAINT "FK_price_categories_movie_categories" FOREIGN KEY (movie_category_id) REFERENCES public.movie_categories(uid);


--
-- TOC entry 2774 (class 2606 OID 16528)
-- Name: shelude_sessions FK_shelude_sessions_halls; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.shelude_sessions
    ADD CONSTRAINT "FK_shelude_sessions_halls" FOREIGN KEY (hall_id) REFERENCES public.halls(uid);


--
-- TOC entry 2773 (class 2606 OID 16523)
-- Name: shelude_sessions FK_shelude_sessions_movies; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.shelude_sessions
    ADD CONSTRAINT "FK_shelude_sessions_movies" FOREIGN KEY (movie_id) REFERENCES public.movies(uid);


-- Completed on 2023-12-09 11:40:17

--
-- PostgreSQL database dump complete
--

