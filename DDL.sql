CREATE TABLE "order" (
  "id" serial PRIMARY KEY,
  "user_id" int,
  "date_create" timestamp DEFAULT (now()),
  "cost" int
);

CREATE TABLE "ticket" (
  "id" serial PRIMARY KEY,
  "order_id" int,
  "seat_price_id" int
);

CREATE TABLE "session" (
  "id" serial PRIMARY KEY,
  "time" timestamp,
  "hall_id" int,
  "movie_id" int
);

CREATE TABLE "hall" (
  "id" serial PRIMARY KEY,
  "name" varchar
);

CREATE TABLE "seat_map" (
  "id" serial PRIMARY KEY,
  "seat_id" int,
  "hall_id" int
);

CREATE TABLE "seat" (
  "id" serial PRIMARY KEY,
  "row" int,
  "seat" int
);

CREATE TABLE "seat_price" (
  "id" serial PRIMARY KEY,
  "price" int,
  "seat_map_id" int,
  "session_id" int
);

CREATE TABLE "user" (
  "id" serial PRIMARY KEY,
  "name" varchar,
  "phone" varchar
);

CREATE TABLE "movie" (
  "id" serial PRIMARY KEY,
  "title" varchar,
  "description" varchar,
  "duration" int
);

CREATE TABLE "movie_attribute_value" (
  "id" serial PRIMARY KEY,
  "movie_id" int,
  "attr_id" int,
  "value_date" date,
  "value_text" text,
  "value_numeric" numeric(2,0),
  "value_boolean" boolean
);

CREATE TABLE "movie_attribute" (
  "id" serial PRIMARY KEY,
  "attr_type_id" int,
  "name" varchar
);

CREATE TABLE "movie_attribute_type" (
  "id" serial PRIMARY KEY,
  "name" varchar,
  "comment" text DEFAULT ''
);

ALTER TABLE "ticket" ADD FOREIGN KEY ("order_id") REFERENCES "order" ("id");

ALTER TABLE "session" ADD FOREIGN KEY ("hall_id") REFERENCES "hall" ("id");

ALTER TABLE "seat_map" ADD FOREIGN KEY ("hall_id") REFERENCES "hall" ("id");

ALTER TABLE "seat_map" ADD FOREIGN KEY ("seat_id") REFERENCES "seat" ("id");

ALTER TABLE "seat_price" ADD FOREIGN KEY ("seat_map_id") REFERENCES "seat_map" ("id");

ALTER TABLE "ticket" ADD FOREIGN KEY ("seat_price_id") REFERENCES "seat_price" ("id");

ALTER TABLE "seat_price" ADD FOREIGN KEY ("session_id") REFERENCES "session" ("id");

ALTER TABLE "order" ADD FOREIGN KEY ("user_id") REFERENCES "user" ("id");

ALTER TABLE "session" ADD FOREIGN KEY ("movie_id") REFERENCES "movie" ("id");

ALTER TABLE "movie_attribute_value" ADD FOREIGN KEY ("movie_id") REFERENCES "movie" ("id");

ALTER TABLE "movie_attribute_value" ADD FOREIGN KEY ("attr_id") REFERENCES "movie_attribute" ("id");

ALTER TABLE "movie_attribute" ADD FOREIGN KEY ("attr_type_id") REFERENCES "movie_attribute_type" ("id");


-- Создание индексов

CREATE INDEX idx_value_movie_id ON movie_attribute_value(movie_id);
CREATE INDEX idx_value_attribute_id ON movie_attribute_value(attr_id);

-- Создание View

CREATE VIEW service_date as
SELECT movie.title as movie,
       CASE
           WHEN movie_attribute_value.value_date::date = CURRENT_TIMESTAMP::date
               THEN movie_attribute.name
        END AS today,
       CASE
           WHEN movie_attribute_value.value_date::date = CURRENT_TIMESTAMP::date + INTERVAL '20 days'
               THEN movie_attribute.name
        END AS after_20_days
FROM movie
    INNER JOIN movie_attribute_value ON movie.id = movie_attribute_value.movie_id
    INNER JOIN movie_attribute ON movie_attribute_value.attr_id = movie_attribute.id
    INNER JOIN movie_attribute_type ON movie_attribute.attr_type_id = movie_attribute_type.id
WHERE movie_attribute_type.id = 4;

CREATE VIEW marketing_data as
SELECT movie.title as movie,
       movie_attribute_type.name as attribute_type,
       movie_attribute.name as attribute_name,
       (coalesce(
               movie_attribute_value.value_date ::text,
               movie_attribute_value.value_text ::text,
               movie_attribute_value.value_numeric ::text,
               movie_attribute_value.value_boolean ::text
        )) as attribute_value
FROM movie
         INNER JOIN movie_attribute_value ON movie.id = movie_attribute_value.movie_id
         INNER JOIN movie_attribute ON movie_attribute_value.attr_id = movie_attribute.id
         INNER JOIN movie_attribute_type ON movie_attribute.attr_type_id = movie_attribute_type.id;



