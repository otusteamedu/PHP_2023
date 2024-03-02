CREATE TABLE "user" (
        id BIGSERIAL PRIMARY KEY,
        email VARCHAR(40) NOT NULL UNIQUE,
        password_hash VARCHAR(256) NOT NULL,
        name VARCHAR(100) NOT NULL
);

CREATE TABLE "cinema" (
        id BIGSERIAL PRIMARY KEY,
        name VARCHAR(100) NOT NULL
);

CREATE TABLE "movie" (
        id BIGSERIAL PRIMARY KEY,
        title VARCHAR(50) NOT NULL,
        year integer
);

CREATE TABLE "session_time" (
        id BIGSERIAL PRIMARY KEY,
        time VARCHAR(5) NOT NULL
);

CREATE TABLE "seat" (
        id BIGSERIAL PRIMARY KEY,
        "row" integer,
        col integer
);

CREATE TABLE "ticket" (
       id BIGSERIAL PRIMARY KEY,
       cinema_id integer REFERENCES cinema(id),
       movie_id integer REFERENCES movie(id),
       session_time_id integer REFERENCES session_time(id),
       seat_id integer REFERENCES seat(id),
       user_id integer REFERENCES "user"(id),
       date date,
       price numeric,
       CHECK (price > 0),
       vip boolean,
       paid boolean
);