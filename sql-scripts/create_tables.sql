CREATE TABLE "user" (
        id BIGSERIAL PRIMARY KEY,
        email VARCHAR(40) NOT NULL UNIQUE,
        password_hash VARCHAR(256) NOT NULL,
        name VARCHAR(100) NOT NULL
);

CREATE TABLE "cinema_hall" (
        id BIGSERIAL PRIMARY KEY,
        name VARCHAR(100) NOT NULL
);

CREATE TABLE "movie" (
        id BIGSERIAL PRIMARY KEY,
        title VARCHAR(50) NOT NULL,
        year integer NOT NULL
);

CREATE TABLE "seat" (
        id BIGSERIAL PRIMARY KEY,
        "row" integer,
        col integer,
        vip bool,
        cinema_hall_id integer REFERENCES cinema_hall(id)
);

CREATE TABLE "session" (
        id BIGSERIAL PRIMARY KEY,
        movie_id integer REFERENCES movie(id),
        cinema_hall_id integer REFERENCES cinema_hall(id),
        date timestamptz NOT NULL
);

CREATE TABLE "ticket_price" (
        id BIGSERIAL PRIMARY KEY,
        session_id integer REFERENCES session(id),
        seat_id integer REFERENCES seat(id),
        price numeric,
        CHECK (price > 0),
        UNIQUE (session_id, seat_id)
);

CREATE TABLE "ticket" (
        id BIGSERIAL PRIMARY KEY,
        session_id integer REFERENCES session(id),
        seat_id integer REFERENCES seat(id),
        ticket_price_id integer REFERENCES ticket_price(id),
        UNIQUE (session_id, seat_id, ticket_price_id)
);

CREATE TABLE "order" (
       id BIGSERIAL PRIMARY KEY,
       ticket_id integer REFERENCES ticket(id),
       user_id integer REFERENCES "user"(id),
       is_paid bool,
       date timestamptz NOT NULL
);