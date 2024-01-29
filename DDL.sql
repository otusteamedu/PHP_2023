CREATE TABLE IF NOT EXISTS cinema_hall
(
    id   integer NOT NULL,
    name varchar NOT NULL
);

COMMENT ON TABLE cinema_hall IS 'Кинозалы';

ALTER TABLE cinema_hall
    OWNER TO postgres;

ALTER TABLE cinema_hall
    ADD CONSTRAINT cinema_hall_pk
        PRIMARY KEY (id);

CREATE TABLE IF NOT EXISTS cinema_session
(
    id             integer   NOT NULL,
    date           timestamp NOT NULL,
    film_id        integer   NOT NULL,
    cinema_hall_id integer   NOT NULL
);

COMMENT ON TABLE cinema_session IS 'Сеансы';

ALTER TABLE cinema_session
    OWNER TO postgres;

ALTER TABLE cinema_session
    ADD CONSTRAINT cinema_session_pk
        PRIMARY KEY (id);

ALTER TABLE cinema_session
    ADD CONSTRAINT cinema_session_cinema_hall_id_fk
        FOREIGN KEY (cinema_hall_id) REFERENCES cinema_hall;

CREATE TABLE IF NOT EXISTS films
(
    id              integer NOT NULL,
    name            varchar NOT NULL,
    age_category_id integer NOT NULL
);

COMMENT ON TABLE films IS 'Фильмы';

ALTER TABLE films
    OWNER TO postgres;

ALTER TABLE films
    ADD CONSTRAINT films_pk
        PRIMARY KEY (id);

ALTER TABLE cinema_session
    ADD CONSTRAINT cinema_session_films_id_fk
        FOREIGN KEY (film_id) REFERENCES films;

CREATE TABLE IF NOT EXISTS places_type
(
    id   integer NOT NULL,
    name varchar NOT NULL
);

COMMENT ON TABLE places_type IS 'Виды билетов';

ALTER TABLE places_type
    OWNER TO postgres;

ALTER TABLE places_type
    ADD CONSTRAINT places_type_pk
        PRIMARY KEY (id);

CREATE TABLE IF NOT EXISTS cinema_hall_capacity
(
    id             integer NOT NULL,
    count_places   integer NOT NULL,
    cinema_hall_id integer NOT NULL,
    places_type_id integer NOT NULL
);

COMMENT ON TABLE cinema_hall_capacity IS 'Вместительность кинозала';

ALTER TABLE cinema_hall_capacity
    OWNER TO postgres;

ALTER TABLE cinema_hall_capacity
    ADD CONSTRAINT cinema_hall_capacity_pk
        PRIMARY KEY (id);

ALTER TABLE cinema_hall_capacity
    ADD CONSTRAINT cinema_hall_capacity_cinema_hall_id_fk
        FOREIGN KEY (cinema_hall_id) REFERENCES cinema_hall;

ALTER TABLE cinema_hall_capacity
    ADD CONSTRAINT cinema_hall_capacity_places_type_id_fk
        FOREIGN KEY (places_type_id) REFERENCES places_type;

CREATE TABLE IF NOT EXISTS tickets
(
    id                serial PRIMARY KEY,
    places_id         integer NOT NULL,
    cinema_session_id integer NOT NULL,
    price             money   NOT NULL
);

COMMENT ON TABLE tickets IS 'Билеты';

ALTER TABLE tickets
    OWNER TO postgres;

ALTER TABLE tickets
    ADD CONSTRAINT tickets_cinema_session_id_fk
        FOREIGN KEY (cinema_session_id) REFERENCES cinema_session;

CREATE TABLE IF NOT EXISTS places
(
    id             integer NOT NULL,
    row            integer NOT NULL,
    place          integer NOT NULL,
    places_type_id integer NOT NULL,
    cinema_hall_id integer NOT NULL
);

COMMENT ON TABLE places IS 'Места';

ALTER TABLE places
    OWNER TO postgres;

ALTER TABLE places
    ADD CONSTRAINT places_pk
        PRIMARY KEY (id);

ALTER TABLE places
    ADD CONSTRAINT places_places_type_id_fk
        FOREIGN KEY (places_type_id) REFERENCES places_type;

ALTER TABLE places
    ADD CONSTRAINT tickets_cinema_hall_id_fk
        FOREIGN KEY (cinema_hall_id) REFERENCES cinema_hall;

CREATE TABLE IF NOT EXISTS age_categories
(
    id   integer NOT NULL,
    name varchar NOT NULL
);

COMMENT ON TABLE age_categories IS 'Возрастные категории';

ALTER TABLE age_categories
    OWNER TO postgres;

ALTER TABLE age_categories
    ADD CONSTRAINT age_categories_pk
        PRIMARY KEY (id);

ALTER TABLE films
    ADD CONSTRAINT films_age_categories_id_fk
        FOREIGN KEY (age_category_id) REFERENCES age_categories;

CREATE TABLE IF NOT EXISTS prices
(
    cinema_session_id integer NOT NULL,
    places_type_id    integer NOT NULL,
    price             money   NOT NULL
);

COMMENT ON TABLE prices IS 'Цены';

ALTER TABLE prices
    OWNER TO postgres;

ALTER TABLE prices
    ADD CONSTRAINT prices_pk
        PRIMARY KEY (places_type_id, cinema_session_id);

ALTER TABLE prices
    ADD CONSTRAINT prices_cinema_session_id_fk
        FOREIGN KEY (cinema_session_id) REFERENCES cinema_session;

ALTER TABLE prices
    ADD CONSTRAINT prices_places_type_id_fk
        FOREIGN KEY (places_type_id) REFERENCES places_type;

