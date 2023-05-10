CREATE TABLE "cinema_halls" (
    "id" BIGINT NOT NULL,
    "name" VARCHAR NOT NULL,
    PRIMARY KEY ("id")
);

CREATE TABLE "genres" (
    "id" BIGINT NOT NULL,
    "name" VARCHAR NOT NULL,
    PRIMARY KEY ("id")
);

CREATE TABLE "movies" (
    "id" BIGINT NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    "description" TEXT DEFAULT NULL,
    "duration" INT DEFAULT NULL,
    PRIMARY KEY ("id")
);

CREATE TABLE "attribute_types" (
    "id" BIGINT NOT NULL,
    "key" VARCHAR(255) NOT NULL,
    "type" VARCHAR(10) NOT NULL,
    PRIMARY KEY ("id")
);

CREATE TABLE "attributes" (
    "id" BIGINT NOT NULL,
    "type_id" BIGINT NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    PRIMARY KEY ("id")
);

CREATE TABLE "movie_attribute_values" (
    "id" BIGINT NOT NULL,
    "movie_id" BIGINT NOT NULL,
    "attribute_id" BIGINT NOT NULL,
    "value_boolean" BOOLEAN DEFAULT NULL,
    "value_int" INT DEFAULT NULL,
    "value_float" NUMERIC(10, 4) DEFAULT NULL,
    "value_text" TEXT DEFAULT NULL,
    "value_date" TIMESTAMPTZ DEFAULT NULL,
    PRIMARY KEY ("id")
);

CREATE TABLE "movie_genres" (
    "movie_id" BIGINT NOT NULL,
    "genre_id" BIGINT NOT NULL,
    PRIMARY KEY ("movie_id", "genre_id")
);

CREATE TABLE "place_types" (
    "id" BIGINT NOT NULL,
    "name" VARCHAR NOT NULL,
    PRIMARY KEY ("id")
);

CREATE TABLE "places" (
    "id" BIGINT NOT NULL,
    "cinema_hall_id" BIGINT NOT NULL,
    "row" INT NOT NULL,
    "place" INT NOT NULL,
    "place_type_id" BIGINT NOT NULL,
    PRIMARY KEY ("id")
);

CREATE TABLE "schedules" (
    "id" BIGINT NOT NULL,
    "datetime" TIMESTAMP NOT NULL,
    "movie_id" BIGINT NOT NULL,
    "cinema_hall_id" BIGINT NOT NULL,
    PRIMARY KEY ("id")
);

CREATE TABLE "schedule_prices" (
    "schedule_id" BIGINT NOT NULL,
    "place_type_id" BIGINT NOT NULL,
    "price" NUMERIC(10,2) NOT NULL,
    PRIMARY KEY ("schedule_id", "place_type_id")
);

CREATE TABLE "tickets" (
    "id" BIGINT NOT NULL,
    "movie_id" BIGINT NOT NULL,
    "place_id" BIGINT NOT NULL,
    "datetime" INTEGER NOT NULL,
    "amount" NUMERIC(10,2) NOT NULL,
    "created_at" INTEGER NOT NULL,
    PRIMARY KEY ("id")
);

CREATE SEQUENCE "movies_id_seq" INCREMENT BY 1 MINVALUE 1 START 1;

CREATE SEQUENCE "attribute_types_id_seq" INCREMENT BY 1 MINVALUE 1 START 1;

CREATE SEQUENCE "attributes_id_seq" INCREMENT BY 1 MINVALUE 1 START 1;

CREATE SEQUENCE "movie_attribute_values_id_seq" INCREMENT BY 1 MINVALUE 1 START 1;

CREATE SEQUENCE "cinema_halls_id_seq" INCREMENT BY 1 MINVALUE 1 START 1;

CREATE SEQUENCE "genres_id_seq" INCREMENT BY 1 MINVALUE 1 START 1;

CREATE SEQUENCE "place_types_id_seq" INCREMENT BY 1 MINVALUE 1 START 1;

CREATE SEQUENCE "places_id_seq" INCREMENT BY 1 MINVALUE 1 START 1;

CREATE SEQUENCE "schedules_id_seq" INCREMENT BY 1 MINVALUE 1 START 1;

CREATE SEQUENCE "tickets_id_seq" INCREMENT BY 1 MINVALUE 1 START 1;

ALTER TABLE "movie_genres" ADD FOREIGN KEY ("movie_id") REFERENCES "movies" ("id");

ALTER TABLE "movie_genres" ADD FOREIGN KEY ("genre_id") REFERENCES "genres" ("id");

ALTER TABLE "places" ADD FOREIGN KEY ("cinema_hall_id") REFERENCES "cinema_halls" ("id");

ALTER TABLE "places" ADD FOREIGN KEY ("place_type_id") REFERENCES "place_types" ("id");

ALTER TABLE "schedules" ADD FOREIGN KEY ("movie_id") REFERENCES "movies" ("id");

ALTER TABLE "schedules" ADD FOREIGN KEY ("cinema_hall_id") REFERENCES "cinema_halls" ("id");

ALTER TABLE "schedule_prices" ADD FOREIGN KEY ("schedule_id") REFERENCES "schedules" ("id");

ALTER TABLE "schedule_prices" ADD FOREIGN KEY ("place_type_id") REFERENCES "place_types" ("id");

ALTER TABLE "tickets" ADD FOREIGN KEY ("movie_id") REFERENCES "movies" ("id");

ALTER TABLE "tickets" ADD FOREIGN KEY ("place_id") REFERENCES "places" ("id");

ALTER TABLE "attributes" ADD FOREIGN KEY ("type_id") REFERENCES "attribute_types" ("id");

ALTER TABLE "movie_attribute_values" ADD FOREIGN KEY ("movie_id") REFERENCES "movies" ("id");

ALTER TABLE "movie_attribute_values" ADD FOREIGN KEY ("attribute_id") REFERENCES "attributes" ("id");

ALTER TABLE "attribute_types" ADD CONSTRAINT "attribute_types_unique_key" UNIQUE ("key");
