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
  "name" VARCHAR NOT NULL,
  "description" TEXT NULL,
  "poster_url" VARCHAR NULL,
  "trailer_url" VARCHAR NULL,
  "duration" INT NOT NULL,
  PRIMARY KEY ("id")
);

CREATE TABLE "movie_genres" (
  "movie_id" BIGINT NOT NULL,
  "genre_id" BIGINT NOT NULL,
  PRIMARY KEY ("movie_id", "genre_id")
);

CREATE TABLE "places" (
  "id" BIGINT NOT NULL,
  "cinema_hall_id" BIGINT NOT NULL,
  "row" INT NOT NULL,
  "place" INT NOT NULL,
  PRIMARY KEY ("id")
);

CREATE TABLE "schedules" (
  "id" BIGINT NOT NULL,
  "datetime" TIMESTAMP NOT NULL,
  "movie_id" BIGINT NOT NULL,
  "cinema_hall_id" BIGINT NOT NULL,
  "price" NUMERIC(10,2) NOT NULL,
  PRIMARY KEY ("id")
);

CREATE TABLE "tickets" (
  "id" BIGINT NOT NULL,
  "movie_id" BIGINT NOT NULL,
  "place_id" BIGINT NOT NULL,
  "datetime" TIMESTAMP NOT NULL,
  "amount" NUMERIC(10,2) NOT NULL,
  "created_at" TIMESTAMP NOT NULL,
  PRIMARY KEY ("id")
);

CREATE SEQUENCE "cinema_halls_id_seq" INCREMENT BY 1 MINVALUE 1 START 1;

CREATE SEQUENCE "genres_id_seq" INCREMENT BY 1 MINVALUE 1 START 1;

CREATE SEQUENCE "movies_id_seq" INCREMENT BY 1 MINVALUE 1 START 1;

CREATE SEQUENCE "movie_genres_id_seq" INCREMENT BY 1 MINVALUE 1 START 1;

CREATE SEQUENCE "places_id_seq" INCREMENT BY 1 MINVALUE 1 START 1;

CREATE SEQUENCE "schedules_id_seq" INCREMENT BY 1 MINVALUE 1 START 1;

CREATE SEQUENCE "tickets_id_seq" INCREMENT BY 1 MINVALUE 1 START 1;

ALTER TABLE "movie_genres" ADD FOREIGN KEY ("movie_id") REFERENCES "movies" ("id");

ALTER TABLE "movie_genres" ADD FOREIGN KEY ("genre_id") REFERENCES "genres" ("id");

ALTER TABLE "places" ADD FOREIGN KEY ("cinema_hall_id") REFERENCES "cinema_halls" ("id");

ALTER TABLE "schedules" ADD FOREIGN KEY ("movie_id") REFERENCES "movies" ("id");

ALTER TABLE "schedules" ADD FOREIGN KEY ("cinema_hall_id") REFERENCES "cinema_halls" ("id");

ALTER TABLE "tickets" ADD FOREIGN KEY ("movie_id") REFERENCES "movies" ("id");

ALTER TABLE "tickets" ADD FOREIGN KEY ("place_id") REFERENCES "places" ("id");
