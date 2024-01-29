CREATE TABLE public.attributes
(
    id integer NOT NULL,
    name text NOT NULL,
    attribute_type_id integer NOT NULL
);


ALTER TABLE public.attributes OWNER TO sitemanager;

ALTER TABLE public.attributes ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY
    (
    SEQUENCE NAME public.attributes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    );

CREATE TABLE public.attributes_type
(
    id integer NOT NULL,
    name text NOT NULL
);

ALTER TABLE public.attributes_type OWNER TO sitemanager;

ALTER TABLE public.attributes_type ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY
    (
    SEQUENCE NAME public.attributes_type_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    );

CREATE TABLE public.attributes_values
(
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

ALTER TABLE public.attributes_values ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY
    (
    SEQUENCE NAME public.attributes_values_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    );

CREATE TABLE public.halls
(
    id integer NOT NULL,
    name character(255) NOT NULL
);

ALTER TABLE public.halls OWNER TO sitemanager;

ALTER TABLE public.halls ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.halls_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    );

CREATE TABLE public.movies
(
    id integer NOT NULL,
    name character(255) NOT NULL,
    duration time without time zone NOT NULL,
    release_date date
);

ALTER TABLE public.movies OWNER TO sitemanager;

ALTER TABLE public.movies ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY
(
    SEQUENCE NAME public.movies_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);

CREATE TABLE public.seat_map
(
    id integer NOT NULL,
    hall_id integer NOT NULL,
    seat_id integer NOT NULL
);

ALTER TABLE public.seat_map OWNER TO sitemanager;

ALTER TABLE public.seat_map ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY
(
    SEQUENCE NAME public.seat_map_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);

CREATE TABLE public.seats
(
    id integer NOT NULL,
    seat_number character(10) NOT NULL,
    row_number integer NOT NULL
);

ALTER TABLE public.seats OWNER TO sitemanager;

ALTER TABLE public.seats ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY
(
    SEQUENCE NAME public.seats_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);

CREATE TABLE public.session_price
(
    id integer NOT NULL,
    seat_map_id integer NOT NULL,
    session_id integer NOT NULL,
    price money NOT NULL
);

ALTER TABLE public.session_price OWNER TO sitemanager;

ALTER TABLE public.session_price ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY
(
    SEQUENCE NAME public.session_price_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);

CREATE TABLE public.sessions
(
    id integer NOT NULL,
    datetime timestamp without time zone NOT NULL,
    hall_id integer NOT NULL,
    movie_id integer NOT NULL
);

ALTER TABLE public.sessions OWNER TO sitemanager;

ALTER TABLE public.sessions ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY
(
    SEQUENCE NAME public.sessions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);

CREATE TABLE public.tickets
(
    id integer NOT NULL,
    session_id integer NOT NULL,
    status character(20) DEFAULT 'new'::bpchar NOT NULL,
    date_purchase timestamp without time zone DEFAULT CURRENT_DATE NOT NULL,
    seat_map_id integer
);


ALTER TABLE public.tickets OWNER TO sitemanager;

ALTER TABLE public.tickets ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY
(
    SEQUENCE NAME public.tickets_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);
