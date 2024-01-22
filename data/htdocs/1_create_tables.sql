DROP TABLE IF EXISTS tickets;
DROP TABLE IF EXISTS seats;
DROP TABLE IF EXISTS sessions;
DROP TABLE IF EXISTS halls;
DROP TABLE IF EXISTS films;
DROP TABLE IF EXISTS users;

CREATE TABLE IF NOT EXISTS "halls"
(
    "id"   serial unique not null,
    "name" varchar
);

CREATE TABLE "seats"
(
    "id"           serial primary key not null,
    "row_number"   int                not null,
    "place_number" int                not null,
    "hall_id"      int REFERENCES halls (id) ON DELETE CASCADE,
    UNIQUE (hall_id, row_number, place_number)
);

CREATE TABLE "films"
(
    "id"           serial primary key not null,
    "name"         varchar            not null,
    "description"  text               null,
    "kp_rating"    numeric            null,
    "duration"     int                not null,
    "release_date" date               not null,
    "cover_id"     int                null REFERENCES files ("id") ON DELETE SET NULL
);

CREATE TABLE "users"
(
    "id"        serial primary key not null,
    "name"      varchar            not null,
    "last_name" varchar            not null,
    "password"  varchar            not null,
    "email"     varchar            not null UNIQUE,
    "avatar"    int                null REFERENCES files (id) ON DELETE SET NULL
);

CREATE EXTENSION IF NOT EXISTS btree_gist;
CREATE TABLE IF NOT EXISTS "sessions"
(
    "id"          serial primary key not null,
    "date"        date, -- для отчёта по прибыльности за период
    "during_time" tsrange,
    "film_id"     integer            not null REFERENCES films ("id") ON DELETE CASCADE,
    "hall_id"     int                not null REFERENCES halls ("id") ON DELETE CASCADE,
    CONSTRAINT hall_usage EXCLUDE USING GIST(hall_id WITH =, during_time WITH &&)
    -- кажется, что нужно еще сделать CONSTRAINT для проверки чтобы время когда зал занят, было больше либо равно продолжительности фильма, но как не знаю
);

CREATE TABLE IF NOT EXISTS "tickets"
(
    "id"          serial primary key NOT null,
    "session_id"  int                NOT null REFERENCES sessions ("id") ON DELETE CASCADE,
    "seat_id"     int                NOT null REFERENCES seats ("id") ON DELETE SET NULL,
    "customer_id" int                NOT NULL REFERENCES users (id) ON DELETE CASCADE,
    "sale_price"  int,
    UNIQUE (session_id, seat_id)    -- на одном сеансе не могут быть заняты два одинаковых места
    --, UNIQUE (session_id, customer_id) --на одном сеансе не может находится один пользователь два раза
);

CREATE TABLE IF NOT EXISTS "discounts_types"
(
    "id"   serial primary key NOT null,
    "name" varchar            not null
);


CREATE TABLE IF NOT EXISTS "discounts"
(
    "id"               serial primary key             NOT null,
    "name"             varchar                        not null,
    "discount_type_id" int REFERENCES discounts_types not null,
    "value"            int                            not null
);
