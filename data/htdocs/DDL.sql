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
DROP TABLE IF EXISTS films;
DROP TABLE IF EXISTS files;

CREATE TABLE "files"
(
    "id"           serial primary key not null,
    "created_date" timestamp          not null,
    "description"  varchar            null,
    "path"         varchar            not null,
    "size"         int                not null,
    "type"         varchar            not null
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
WHERE a.group_id = 4
