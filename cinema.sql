BEGIN;


CREATE TABLE IF NOT EXISTS public.genres
(
    id smallserial,
    title character varying COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT genres_pkey PRIMARY KEY (id),
    CONSTRAINT genres_title_key UNIQUE (title)
);

CREATE TABLE IF NOT EXISTS public.movies
(
    id bigserial,
    title character varying COLLATE pg_catalog."default" NOT NULL,
    year_premier smallint NOT NULL,
    genre_id smallint NOT NULL,
    CONSTRAINT movies_pkey PRIMARY KEY (id),
    CONSTRAINT movies_title_key UNIQUE (title)
);

CREATE TABLE IF NOT EXISTS public.sessions
(
    id bigserial,
    date time with time zone NOT NULL,
    movie_id bigint NOT NULL,
    holl_id smallserial NOT NULL,
    price integer NOT NULL,
    CONSTRAINT sessions_pkey PRIMARY KEY (id),
    CONSTRAINT sessions_date_holl_id_key UNIQUE (date, holl_id)
);

CREATE TABLE IF NOT EXISTS public.holls
(
    id smallserial,
    title character varying(4) COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT holls_pkey PRIMARY KEY (id),
    CONSTRAINT holls_title_key UNIQUE (title)
);

CREATE TABLE IF NOT EXISTS public.locations
(
    id serial,
    holl_id smallserial NOT NULL,
    seat_id smallserial NOT NULL,
    row_id smallserial NOT NULL,
    category_id smallserial NOT NULL,
    CONSTRAINT locations_pkey PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public.seats_categories
(
    id smallserial,
    title character varying COLLATE pg_catalog."default" NOT NULL,
    increase double precision NOT NULL DEFAULT 1.0,
    CONSTRAINT seats_categories_pkey PRIMARY KEY (id),
    CONSTRAINT seats_categories_title_key UNIQUE (title)
);

CREATE TABLE IF NOT EXISTS public.rows
(
    id smallserial,
    title character varying(3) COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT rows_pkey PRIMARY KEY (id),
    CONSTRAINT rows_title_key UNIQUE (title)
);

CREATE TABLE IF NOT EXISTS public.seats
(
    id smallserial,
    title character varying(3) COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT seats_pkey PRIMARY KEY (id),
    CONSTRAINT seats_title_key UNIQUE (title)
);

CREATE TABLE IF NOT EXISTS public.tickets
(
    id bigserial,
    session_id bigint NOT NULL,
    location_id integer NOT NULL,
    promo_id integer,
    total_price double precision NOT NULL,
    CONSTRAINT tickets_pkey PRIMARY KEY (id),
    CONSTRAINT tickets_session_id_location_id_key UNIQUE (session_id, location_id)
);

CREATE TABLE IF NOT EXISTS public.promo
(
    id serial NOT NULL,
    title text NOT NULL,
    discount smallint NOT NULL,
    PRIMARY KEY (id),
    UNIQUE (title)
);

ALTER TABLE IF EXISTS public.movies
    ADD CONSTRAINT movies_genre_id_fkey FOREIGN KEY (genre_id)
        REFERENCES public.genres (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE SET NULL
        NOT VALID;


ALTER TABLE IF EXISTS public.sessions
    ADD CONSTRAINT sessions_holl_id FOREIGN KEY (holl_id)
        REFERENCES public.holls (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE CASCADE
        NOT VALID;


ALTER TABLE IF EXISTS public.sessions
    ADD CONSTRAINT sessions_movie_id FOREIGN KEY (movie_id)
        REFERENCES public.movies (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE CASCADE
        NOT VALID;


ALTER TABLE IF EXISTS public.locations
    ADD CONSTRAINT locations_category_id FOREIGN KEY (category_id)
        REFERENCES public.seats_categories (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE SET DEFAULT
        NOT VALID;


ALTER TABLE IF EXISTS public.locations
    ADD CONSTRAINT locations_holl_id FOREIGN KEY (holl_id)
        REFERENCES public.holls (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE CASCADE
        NOT VALID;


ALTER TABLE IF EXISTS public.locations
    ADD CONSTRAINT locations_row_id FOREIGN KEY (row_id)
        REFERENCES public.rows (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE CASCADE
        NOT VALID;


ALTER TABLE IF EXISTS public.locations
    ADD CONSTRAINT locations_seat_id FOREIGN KEY (seat_id)
        REFERENCES public.seats (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE CASCADE
        NOT VALID;


ALTER TABLE IF EXISTS public.tickets
    ADD CONSTRAINT tickets_locations_id FOREIGN KEY (location_id)
        REFERENCES public.locations (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE CASCADE
        NOT VALID;


ALTER TABLE IF EXISTS public.tickets
    ADD CONSTRAINT tickets_sessions_id FOREIGN KEY (session_id)
        REFERENCES public.sessions (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE CASCADE
        NOT VALID;


ALTER TABLE IF EXISTS public.tickets
    ADD CONSTRAINT tickets_promo_id FOREIGN KEY (promo_id)
        REFERENCES public.promo (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE SET NULL
        NOT VALID;

END;
