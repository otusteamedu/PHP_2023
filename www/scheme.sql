

CREATE TABLE public.attributes (
                                   id integer NOT NULL,
                                   name text NOT NULL,
                                   attribute_type_id integer NOT NULL
);


ALTER TABLE public.attributes OWNER TO sitemanager;

--
-- TOC entry 216 (class 1259 OID 16394)
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
-- TOC entry 217 (class 1259 OID 16395)
-- Name: attributes_type; Type: TABLE; Schema: public; Owner: sitemanager
--

CREATE TABLE public.attributes_type (
                                        id integer NOT NULL,
                                        name text NOT NULL
);


ALTER TABLE public.attributes_type OWNER TO sitemanager;

--
-- TOC entry 218 (class 1259 OID 16400)
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
-- TOC entry 219 (class 1259 OID 16401)
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
-- TOC entry 220 (class 1259 OID 16406)
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
-- TOC entry 221 (class 1259 OID 16407)
-- Name: genres; Type: TABLE; Schema: public; Owner: sitemanager
--

CREATE TABLE public.genres (
                               id integer NOT NULL,
                               name character(255)
);


ALTER TABLE public.genres OWNER TO sitemanager;

--
-- TOC entry 222 (class 1259 OID 16410)
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
-- TOC entry 223 (class 1259 OID 16411)
-- Name: halls; Type: TABLE; Schema: public; Owner: sitemanager
--

CREATE TABLE public.halls (
                              id integer NOT NULL,
                              name character(255) NOT NULL
);


ALTER TABLE public.halls OWNER TO sitemanager;

--
-- TOC entry 224 (class 1259 OID 16414)
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
-- TOC entry 225 (class 1259 OID 16415)
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
-- TOC entry 226 (class 1259 OID 16418)
-- Name: movies_genres; Type: TABLE; Schema: public; Owner: sitemanager
--

CREATE TABLE public.movies_genres (
                                      id integer NOT NULL,
                                      movie_id integer NOT NULL,
                                      genre_id integer NOT NULL
);


ALTER TABLE public.movies_genres OWNER TO sitemanager;

--
-- TOC entry 227 (class 1259 OID 16421)
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
-- TOC entry 228 (class 1259 OID 16422)
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
-- TOC entry 229 (class 1259 OID 16423)
-- Name: seat_map; Type: TABLE; Schema: public; Owner: sitemanager
--

CREATE TABLE public.seat_map (
                                 id integer NOT NULL,
                                 hall_id integer NOT NULL,
                                 seat_id integer NOT NULL
);


ALTER TABLE public.seat_map OWNER TO sitemanager;

--
-- TOC entry 230 (class 1259 OID 16426)
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
-- TOC entry 231 (class 1259 OID 16427)
-- Name: seats; Type: TABLE; Schema: public; Owner: sitemanager
--

CREATE TABLE public.seats (
                              id integer NOT NULL,
                              seat_number character(10) NOT NULL,
                              row_number integer NOT NULL
);


ALTER TABLE public.seats OWNER TO sitemanager;

--
-- TOC entry 232 (class 1259 OID 16430)
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
-- TOC entry 233 (class 1259 OID 16431)
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
-- TOC entry 234 (class 1259 OID 16434)
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
-- TOC entry 235 (class 1259 OID 16435)
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
-- TOC entry 236 (class 1259 OID 16438)
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
-- TOC entry 237 (class 1259 OID 16439)
-- Name: tickets; Type: TABLE; Schema: public; Owner: sitemanager
--

CREATE TABLE public.tickets (
                                id integer NOT NULL,
                                session_id integer NOT NULL,
                                status character(20) DEFAULT 'new'::bpchar NOT NULL,
                                date_purchase timestamp without time zone DEFAULT CURRENT_DATE NOT NULL,
                                seat_map_id integer
);


ALTER TABLE public.tickets OWNER TO sitemanager;

--
-- TOC entry 238 (class 1259 OID 16444)
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
