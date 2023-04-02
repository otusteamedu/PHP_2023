-- views
DROP VIEW IF EXISTS attributes_values_view;
DROP VIEW IF EXISTS tasks_for_today;
DROP VIEW IF EXISTS tasks_for_20_days;
DROP VIEW IF EXISTS service_dates;

-- tables
DROP TABLE IF EXISTS attributes_values;
DROP TABLE IF EXISTS attributes;
DROP TABLE IF EXISTS attributes_groups;
DROP TABLE IF EXISTS attributes_types;

DROP TABLE IF EXISTS films_genres;
DROP TABLE IF EXISTS genres;
DROP TABLE IF EXISTS tickets;
DROP TABLE IF EXISTS tickets_types;
DROP TABLE IF EXISTS seats;
DROP TABLE IF EXISTS sessions_tickets;
DROP TABLE IF EXISTS sessions;
DROP TABLE IF EXISTS halls;
DROP TABLE IF EXISTS films;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS files;

DROP TABLE IF EXISTS discounts;
DROP TABLE IF EXISTS discounts_types;

CREATE TABLE "files"
(
    "id"           serial primary key not null,
    "created_date" timestamp          not null,
    "description"  varchar            null,
    "path"         varchar            not null,
    "size"         int                not null,
    "type"         varchar            not null
);

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

CREATE TABLE "genres"
(
    "id"   int PRIMARY KEY,
    "name" varchar not null
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

CREATE TABLE "films_genres"
(
    "id"       serial PRIMARY KEY,
    "film_id"  int not null REFERENCES films (id) ON DELETE CASCADE,
    "genre_id" int not null REFERENCES genres (id) ON DELETE CASCADE
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
);

CREATE TABLE IF NOT EXISTS "tickets"
(
    "id"          serial primary key NOT null,
    "session_id"  int                NOT null REFERENCES sessions ("id") ON DELETE CASCADE,
    "seat_id"     int                NOT null REFERENCES seats ("id") ON DELETE SET NULL,
    "customer_id" int                NOT NULL REFERENCES users (id) ON DELETE CASCADE,
    "sale_price"  int,
    UNIQUE (session_id, seat_id),    -- на одном сеансе не могут быть заняты два одинаковых места
    UNIQUE (session_id, customer_id) --на одном сеансе не может находится один пользователь два раза
);

/**********************************************************************************/
/*                                  Discounts                                     */
/**********************************************************************************/
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


/**********************************************************************************/
/*                                  Attributes                                    */
/**********************************************************************************/
CREATE TABLE IF NOT EXISTS "attributes_types"
(
    "id"         smallserial primary key not null,
    "name"       varchar                 not null,
    "field_name" varchar                 not null
);

CREATE TABLE IF NOT EXISTS "attributes_groups"
(
    "id"        serial primary key not null,
    "name"      varchar            not null,
    "parent_id" int                null REFERENCES attributes_groups ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS "attributes"
(
    "id"       serial primary key not null,
    "name"     varchar            not null,
    "group_id" int                null REFERENCES attributes_groups ON DELETE SET NULL,
    "type_id"  int                not null REFERENCES attributes_types ON DELETE CASCADE,
    "multiple" bool default false
);

CREATE TABLE IF NOT EXISTS "attributes_values"
(
    "id"           serial primary key not null,
    "film_id"      int                not null REFERENCES films ON DELETE CASCADE,
    "attribute_id" int                not null REFERENCES attributes ON DELETE CASCADE,
    "description"  varchar            null,
    "bool"         bool               null,
    "string"       varchar            null,
    "text"         text               null,
    "int"          int                null,
    "double"       double PRECISION   null,
    "date"         timestamptz        null
);

/**********************************************************************************************/
/*                                          VIEWS                                             */
/**********************************************************************************************/
-- фильм, тип атрибута, атрибут, значение (значение выводим как текст)
CREATE VIEW attributes_values_view AS
SELECT f.id    as film_id,
       f.name   as film_name,
       a.name  as attribute_name,
       at.name as attribute_type,
       CASE
           WHEN at.field_name = 'text' THEN av.text
           WHEN at.field_name = 'bool' THEN
               CASE
                   WHEN av.bool = true THEN 'есть'
                   WHEN av.bool = false THEN 'нет'
                   END
           WHEN at.field_name = 'date' THEN (av.date)::text
           END    value
FROM attributes_values av
         LEFT JOIN films f on av.film_id = f.id
         LEFT JOIN attributes a on av.attribute_id = a.id
         LEFT JOIN attributes_types at on at.id = a.type_id;

-- фильм, задачи актуальные на сегодня
CREATE VIEW tasks_for_today AS
SELECT f.id    as film_id,
       f.name   as film_name,
       a.name  as attribute_name,
       at.name as attribute_type,
       CASE
           WHEN at.field_name = 'text' THEN av.text
           WHEN at.field_name = 'bool' THEN
               CASE
                   WHEN av.bool = true THEN 'есть'
                   WHEN av.bool = false THEN 'нет'
                   END
           WHEN at.field_name = 'date' THEN (av.date)::text
           END    value
FROM attributes_values av
         LEFT JOIN films f on av.film_id = f.id
         LEFT JOIN attributes a on av.attribute_id = a.id
         LEFT JOIN attributes_types at on at.id = a.type_id
WHERE a.group_id = 4
  AND av.date = current_date;

-- фильм, задачи актуальные через 20 дней
CREATE VIEW tasks_for_20_days AS
SELECT f.id    as film_id,
       f.name   as film_name,
       a.name  as attribute_name,
       at.name as attribute_type,
       CASE
           WHEN at.field_name = 'text' THEN av.text
           WHEN at.field_name = 'bool' THEN
               CASE
                   WHEN av.bool = true THEN 'есть'
                   WHEN av.bool = false THEN 'нет'
                   END
           WHEN at.field_name = 'date' THEN (av.date)::text
           END    value
FROM attributes_values av
         LEFT JOIN films f on av.film_id = f.id
         LEFT JOIN attributes a on av.attribute_id = a.id
         LEFT JOIN attributes_types at on at.id = a.type_id
WHERE a.group_id = 4
  AND av.date = current_date + 20;

-- служебные даты (используются при планировании, тип дата) - дата начала продажи билетов, когда запускать рекламу на ТВ
CREATE VIEW service_dates AS
SELECT f.id   as film_id,
       f.name   as film_name,
       a.name as attribute_name,
       CASE
           WHEN at.field_name = 'text' THEN av.text
           WHEN at.field_name = 'bool' THEN
               CASE
                   WHEN av.bool = true THEN 'есть'
                   WHEN av.bool = false THEN 'нет'
                   END
           WHEN at.field_name = 'date' THEN (av.date)::text
           END   value
FROM attributes_values av
         LEFT JOIN films f on av.film_id = f.id
         LEFT JOIN attributes a on av.attribute_id = a.id
         LEFT JOIN attributes_types at on at.id = a.type_id
WHERE a.group_id = 4;



/**********************************************************************************************/
/*                                      FUNCTIONS                                             */
/**********************************************************************************************/
CREATE OR REPLACE FUNCTION random_between(low INT ,high INT)
    RETURNS INT AS
$$
BEGIN
    RETURN round((random() * (high-low) + low)::NUMERIC, 1);
END;
$$ language 'plpgsql' STRICT;

Create or replace function random_string(length integer) returns text as
$$
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
$$ language plpgsql;

CREATE OR REPLACE FUNCTION random_ts_between(f timestamptz, t timestamptz) RETURNS timestamptz AS
$$
BEGIN
    RETURN to_timestamp(random_between(EXTRACT(EPOCH FROM f)::INT, EXTRACT(EPOCH FROM t)::INT));
END;
$$ language 'plpgsql' STRICT;


CREATE OR REPLACE FUNCTION random_date_between(f DATE, t DATE) RETURNS DATE AS
$$
BEGIN
    RETURN to_char(to_timestamp(random_between(EXTRACT(EPOCH FROM f)::INT, EXTRACT(EPOCH FROM t)::INT)), 'YYYY-MM-DD')::DATE;
END;
$$ language 'plpgsql' STRICT;
