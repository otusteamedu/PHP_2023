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

--
-- Name: random_between(integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.random_between(low integer, high integer) RETURNS integer
    LANGUAGE plpgsql STRICT
    AS $$
BEGIN
   RETURN floor(random()* (high-low + 1) + low);
END;
$$;


ALTER FUNCTION public.random_between(low integer, high integer) OWNER TO postgres;

--
-- Name: random_string(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.random_string(length integer) RETURNS text
    LANGUAGE plpgsql
    AS $$
declare
  chars text[] := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
  result text := '';
  i integer := 0;
begin
  if length < 0 then
    raise exception 'Given length cannot be less than 0';
  end if;
  for i in 1..length loop
    result := result || chars[1+random()*(array_length(chars, 1)-1)];
  end loop;
  return result;
end;
$$;


ALTER FUNCTION public.random_string(length integer) OWNER TO postgres;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: age_restrictions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.age_restrictions (
    id smallint NOT NULL,
    min_age smallint NOT NULL
);


ALTER TABLE public.age_restrictions OWNER TO postgres;

--
-- Name: age_restrictions_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.age_restrictions_id_seq
    AS smallint
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.age_restrictions_id_seq OWNER TO postgres;

--
-- Name: age_restrictions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.age_restrictions_id_seq OWNED BY public.age_restrictions.id;


--
-- Name: film_genres; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.film_genres (
    film_id integer NOT NULL,
    genre_id smallint NOT NULL,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone NOT NULL
);


ALTER TABLE public.film_genres OWNER TO postgres;

--
-- Name: film_type_to_films; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.film_type_to_films (
    film_id integer NOT NULL,
    film_type_id smallint NOT NULL,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone NOT NULL
);


ALTER TABLE public.film_type_to_films OWNER TO postgres;

--
-- Name: film_types; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.film_types (
    id smallint NOT NULL,
    type character varying(20) NOT NULL
);


ALTER TABLE public.film_types OWNER TO postgres;

--
-- Name: film_types_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.film_types_id_seq
    AS smallint
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.film_types_id_seq OWNER TO postgres;

--
-- Name: film_types_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.film_types_id_seq OWNED BY public.film_types.id;


--
-- Name: films; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.films (
    id integer NOT NULL,
    age_restriction_id smallint NOT NULL,
    name character varying(255) NOT NULL,
    duration smallint NOT NULL,
    poster_image_path character varying(255) DEFAULT ''::character varying NOT NULL,
    description character varying(255) DEFAULT ''::character varying NOT NULL,
    actors character varying(255) DEFAULT ''::character varying NOT NULL,
    country character varying(255) DEFAULT ''::character varying NOT NULL,
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
-- Name: genres; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.genres (
    id smallint NOT NULL,
    name character varying(255) NOT NULL
);


ALTER TABLE public.genres OWNER TO postgres;

--
-- Name: genres_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.genres_id_seq
    AS smallint
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.genres_id_seq OWNER TO postgres;

--
-- Name: genres_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.genres_id_seq OWNED BY public.genres.id;


--
-- Name: hall_seats; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.hall_seats (
    id integer NOT NULL,
    hall_id integer NOT NULL,
    start_from_seat smallint NOT NULL,
    seat_priority_id integer NOT NULL,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone NOT NULL
);


ALTER TABLE public.hall_seats OWNER TO postgres;

--
-- Name: hall_seats_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.hall_seats_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.hall_seats_id_seq OWNER TO postgres;

--
-- Name: hall_seats_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.hall_seats_id_seq OWNED BY public.hall_seats.id;


--
-- Name: halls; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.halls (
    id integer NOT NULL,
    amount_of_seats smallint NOT NULL,
    is_avaliable boolean DEFAULT true NOT NULL,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone NOT NULL
);


ALTER TABLE public.halls OWNER TO postgres;

--
-- Name: halls_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.halls_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.halls_id_seq OWNER TO postgres;

--
-- Name: halls_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.halls_id_seq OWNED BY public.halls.id;


--
-- Name: screenings; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.screenings (
    id integer NOT NULL,
    hall_id integer,
    film_id integer,
    film_type_id smallint,
    base_price numeric(6,2) NOT NULL,
    start_at timestamp without time zone NOT NULL,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone NOT NULL
);


ALTER TABLE public.screenings OWNER TO postgres;

--
-- Name: screenings_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.screenings_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.screenings_id_seq OWNER TO postgres;

--
-- Name: screenings_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.screenings_id_seq OWNED BY public.screenings.id;


--
-- Name: seats_priorities; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.seats_priorities (
    id integer NOT NULL,
    priority_level smallint NOT NULL,
    cost_markup numeric(4,2) NOT NULL
);


ALTER TABLE public.seats_priorities OWNER TO postgres;

--
-- Name: seats_priorities_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.seats_priorities_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.seats_priorities_id_seq OWNER TO postgres;

--
-- Name: seats_priorities_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.seats_priorities_id_seq OWNED BY public.seats_priorities.id;


--
-- Name: tickets; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tickets (
    id integer NOT NULL,
    visitor_id integer,
    seat smallint NOT NULL,
    is_child boolean DEFAULT false NOT NULL,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone NOT NULL
);


ALTER TABLE public.tickets OWNER TO postgres;

--
-- Name: tickets_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tickets_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.tickets_id_seq OWNER TO postgres;

--
-- Name: tickets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tickets_id_seq OWNED BY public.tickets.id;


--
-- Name: visitors; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.visitors (
    id integer NOT NULL,
    screening_id integer,
    cashless_payment boolean DEFAULT false NOT NULL,
    price numeric(6,2) NOT NULL,
    discount_percent smallint DEFAULT 0 NOT NULL,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone NOT NULL
);


ALTER TABLE public.visitors OWNER TO postgres;

--
-- Name: visitors_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.visitors_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.visitors_id_seq OWNER TO postgres;

--
-- Name: visitors_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.visitors_id_seq OWNED BY public.visitors.id;


--
-- Name: age_restrictions id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.age_restrictions ALTER COLUMN id SET DEFAULT nextval('public.age_restrictions_id_seq'::regclass);


--
-- Name: film_types id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film_types ALTER COLUMN id SET DEFAULT nextval('public.film_types_id_seq'::regclass);


--
-- Name: films id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.films ALTER COLUMN id SET DEFAULT nextval('public.films_id_seq'::regclass);


--
-- Name: genres id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.genres ALTER COLUMN id SET DEFAULT nextval('public.genres_id_seq'::regclass);


--
-- Name: hall_seats id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.hall_seats ALTER COLUMN id SET DEFAULT nextval('public.hall_seats_id_seq'::regclass);


--
-- Name: halls id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.halls ALTER COLUMN id SET DEFAULT nextval('public.halls_id_seq'::regclass);


--
-- Name: screenings id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.screenings ALTER COLUMN id SET DEFAULT nextval('public.screenings_id_seq'::regclass);


--
-- Name: seats_priorities id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.seats_priorities ALTER COLUMN id SET DEFAULT nextval('public.seats_priorities_id_seq'::regclass);


--
-- Name: tickets id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tickets ALTER COLUMN id SET DEFAULT nextval('public.tickets_id_seq'::regclass);


--
-- Name: visitors id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.visitors ALTER COLUMN id SET DEFAULT nextval('public.visitors_id_seq'::regclass);


--
-- Data for Name: age_restrictions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.age_restrictions (id, min_age) FROM stdin;
1	0
2	8
3	12
4	18
\.


--
-- Data for Name: film_genres; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.film_genres (film_id, genre_id, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: film_type_to_films; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.film_type_to_films (film_id, film_type_id, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: film_types; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.film_types (id, type) FROM stdin;
1	imax
2	2d
3	3d
4	4d
\.


--
-- Data for Name: films; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.films (id, age_restriction_id, name, duration, poster_image_path, description, actors, country, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: genres; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.genres (id, name) FROM stdin;
1	horror
2	comedy
3	action
4	family
5	cartoon
\.


--
-- Data for Name: hall_seats; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.hall_seats (id, hall_id, start_from_seat, seat_priority_id, created_at, updated_at) FROM stdin;
1	1	1	3	2023-10-13 18:53:06.578728	2023-10-13 18:53:06.578728
2	1	15	2	2023-10-13 18:53:06.578728	2023-10-13 18:53:06.578728
3	1	30	1	2023-10-13 18:53:06.578728	2023-10-13 18:53:06.578728
4	2	1	3	2023-10-13 18:53:47.065059	2023-10-13 18:53:47.065059
5	2	40	2	2023-10-13 18:53:47.065059	2023-10-13 18:53:47.065059
6	2	60	1	2023-10-13 18:53:47.065059	2023-10-13 18:53:47.065059
7	3	1	3	2023-10-13 18:54:15.745066	2023-10-13 18:54:15.745066
8	2	70	2	2023-10-13 18:54:15.745066	2023-10-13 18:54:15.745066
9	2	110	1	2023-10-13 18:54:15.745066	2023-10-13 18:54:15.745066
\.


--
-- Data for Name: halls; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.halls (id, amount_of_seats, is_avaliable, created_at, updated_at) FROM stdin;
1	50	t	2023-10-13 18:47:25.16891	2023-10-13 18:47:25.16891
2	150	t	2023-10-13 18:47:25.16891	2023-10-13 18:47:25.16891
3	300	t	2023-10-13 18:47:25.16891	2023-10-13 18:47:25.16891
\.


--
-- Data for Name: screenings; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.screenings (id, hall_id, film_id, film_type_id, base_price, start_at, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: seats_priorities; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.seats_priorities (id, priority_level, cost_markup) FROM stdin;
1	1	1.00
2	2	1.20
3	3	1.50
\.


--
-- Data for Name: tickets; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tickets (id, visitor_id, seat, is_child, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: visitors; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.visitors (id, screening_id, cashless_payment, price, discount_percent, created_at, updated_at) FROM stdin;
\.


--
-- Name: age_restrictions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.age_restrictions_id_seq', 4, true);


--
-- Name: film_types_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.film_types_id_seq', 4, true);


--
-- Name: films_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.films_id_seq', 1, false);


--
-- Name: genres_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.genres_id_seq', 5, true);


--
-- Name: hall_seats_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.hall_seats_id_seq', 9, true);


--
-- Name: halls_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.halls_id_seq', 3, true);


--
-- Name: screenings_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.screenings_id_seq', 1, false);


--
-- Name: seats_priorities_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.seats_priorities_id_seq', 3, true);


--
-- Name: tickets_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tickets_id_seq', 1, false);


--
-- Name: visitors_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.visitors_id_seq', 1, false);


--
-- Name: age_restrictions age_restrictions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.age_restrictions
    ADD CONSTRAINT age_restrictions_pkey PRIMARY KEY (id);


--
-- Name: film_genres film_genres_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film_genres
    ADD CONSTRAINT film_genres_pkey PRIMARY KEY (film_id, genre_id);


--
-- Name: film_type_to_films film_type_to_films_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film_type_to_films
    ADD CONSTRAINT film_type_to_films_pkey PRIMARY KEY (film_id, film_type_id);


--
-- Name: film_types film_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film_types
    ADD CONSTRAINT film_types_pkey PRIMARY KEY (id);


--
-- Name: films films_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.films
    ADD CONSTRAINT films_pkey PRIMARY KEY (id);


--
-- Name: genres genres_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.genres
    ADD CONSTRAINT genres_pkey PRIMARY KEY (id);


--
-- Name: hall_seats hall_seats_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.hall_seats
    ADD CONSTRAINT hall_seats_pkey PRIMARY KEY (id);


--
-- Name: halls halls_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.halls
    ADD CONSTRAINT halls_pkey PRIMARY KEY (id);


--
-- Name: screenings screenings_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.screenings
    ADD CONSTRAINT screenings_pkey PRIMARY KEY (id);


--
-- Name: seats_priorities seats_priorities_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.seats_priorities
    ADD CONSTRAINT seats_priorities_pkey PRIMARY KEY (id);


--
-- Name: tickets tickets_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tickets
    ADD CONSTRAINT tickets_pkey PRIMARY KEY (id);


--
-- Name: visitors visitors_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.visitors
    ADD CONSTRAINT visitors_pkey PRIMARY KEY (id);


--
-- Name: film_genres film_genres_film_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film_genres
    ADD CONSTRAINT film_genres_film_id_fkey FOREIGN KEY (film_id) REFERENCES public.films(id) ON DELETE CASCADE;


--
-- Name: film_genres film_genres_genre_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film_genres
    ADD CONSTRAINT film_genres_genre_id_fkey FOREIGN KEY (genre_id) REFERENCES public.genres(id) ON DELETE CASCADE;


--
-- Name: film_type_to_films film_type_to_films_film_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film_type_to_films
    ADD CONSTRAINT film_type_to_films_film_id_fkey FOREIGN KEY (film_id) REFERENCES public.films(id) ON DELETE CASCADE;


--
-- Name: film_type_to_films film_type_to_films_film_type_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.film_type_to_films
    ADD CONSTRAINT film_type_to_films_film_type_id_fkey FOREIGN KEY (film_type_id) REFERENCES public.film_types(id) ON DELETE CASCADE;


--
-- Name: films films_age_restriction_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.films
    ADD CONSTRAINT films_age_restriction_id_fkey FOREIGN KEY (age_restriction_id) REFERENCES public.age_restrictions(id) ON DELETE RESTRICT;


--
-- Name: hall_seats hall_seats_hall_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.hall_seats
    ADD CONSTRAINT hall_seats_hall_id_fkey FOREIGN KEY (hall_id) REFERENCES public.halls(id) ON DELETE CASCADE;


--
-- Name: hall_seats hall_seats_seat_priority_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.hall_seats
    ADD CONSTRAINT hall_seats_seat_priority_id_fkey FOREIGN KEY (seat_priority_id) REFERENCES public.seats_priorities(id) ON DELETE RESTRICT;


--
-- Name: screenings screenings_film_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.screenings
    ADD CONSTRAINT screenings_film_id_fkey FOREIGN KEY (film_id) REFERENCES public.films(id) ON DELETE SET NULL;


--
-- Name: screenings screenings_film_type_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.screenings
    ADD CONSTRAINT screenings_film_type_id_fkey FOREIGN KEY (film_type_id) REFERENCES public.film_types(id) ON DELETE SET NULL;


--
-- Name: screenings screenings_hall_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.screenings
    ADD CONSTRAINT screenings_hall_id_fkey FOREIGN KEY (hall_id) REFERENCES public.halls(id) ON DELETE SET NULL;


--
-- Name: tickets tickets_visitor_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tickets
    ADD CONSTRAINT tickets_visitor_id_fkey FOREIGN KEY (visitor_id) REFERENCES public.visitors(id) ON DELETE SET NULL;


--
-- Name: visitors visitors_screening_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.visitors
    ADD CONSTRAINT visitors_screening_id_fkey FOREIGN KEY (screening_id) REFERENCES public.screenings(id) ON DELETE SET NULL;


--
-- PostgreSQL database dump complete
--

