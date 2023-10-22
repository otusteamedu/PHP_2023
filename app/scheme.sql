DROP TABLE IF EXISTS "attributes";
DROP SEQUENCE IF EXISTS "Attributes_id_seq";
CREATE SEQUENCE "Attributes_id_seq" INCREMENT  MINVALUE  MAXVALUE  CACHE ;

CREATE TABLE "public"."attributes" (
    "id" integer DEFAULT nextval('"Attributes_id_seq"') NOT NULL,
    "name" text NOT NULL,
    "attribute_type_id" integer NOT NULL,
    CONSTRAINT "attributes_pk" PRIMARY KEY ("id")
) WITH (oids = false);

DROP TABLE IF EXISTS "attributes_type";
DROP SEQUENCE IF EXISTS atributes_type_id_seq;
CREATE SEQUENCE atributes_type_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."attributes_type" (
    "id" integer DEFAULT nextval('atributes_type_id_seq') NOT NULL,
    "name" text NOT NULL,
    CONSTRAINT "atributes_type_pk" PRIMARY KEY ("id")
) WITH (oids = false);

DROP TABLE IF EXISTS "attributes_values";
DROP SEQUENCE IF EXISTS attributes_values_id_seq;
CREATE SEQUENCE attributes_values_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."attributes_values" (
    "id" integer DEFAULT nextval('attributes_values_id_seq') NOT NULL,
    "film_id" integer NOT NULL,
    "attribute_id" integer NOT NULL,
    "value" text,
    CONSTRAINT "attributes_values_pk" PRIMARY KEY ("id")
) WITH (oids = false);

DROP TABLE IF EXISTS "films";
DROP SEQUENCE IF EXISTS films_id_seq;
CREATE SEQUENCE films_id_seq INCREMENT 1 MINVALUE 7 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."films" (
    "id" integer DEFAULT nextval('films_id_seq') NOT NULL,
    "name" text NOT NULL,
    "genre" text NOT NULL,
    "year_of_release" integer NOT NULL,
    "duration" integer NOT NULL,
    CONSTRAINT "films_pk" PRIMARY KEY ("id")
) WITH (oids = false);

DROP TABLE IF EXISTS "halls";
DROP SEQUENCE IF EXISTS halls_id_seq;
CREATE SEQUENCE halls_id_seq INCREMENT 1 MINVALUE 3 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."halls" (
    "id" integer DEFAULT nextval('halls_id_seq') NOT NULL,
    "name" text NOT NULL,
    "rows_number" integer NOT NULL,
    "seats_number" integer NOT NULL,
    CONSTRAINT "halls_pk" PRIMARY KEY ("id")
) WITH (oids = false);

DROP TABLE IF EXISTS "prices";
DROP SEQUENCE IF EXISTS prices_id_seq;
CREATE SEQUENCE prices_id_seq INCREMENT 1 MINVALUE 25 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."prices" (
    "id" integer DEFAULT nextval('prices_id_seq') NOT NULL,
    "session_id" integer NOT NULL,
    "seat_category_id" integer NOT NULL,
    "price" money NOT NULL,
    CONSTRAINT "prices_pk" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "rows_seats_categories";
DROP SEQUENCE IF EXISTS rows_seats_categories_id_seq;
CREATE SEQUENCE rows_seats_categories_id_seq INCREMENT 1 MINVALUE 21 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."rows_seats_categories" (
    "id" integer DEFAULT nextval('rows_seats_categories_id_seq') NOT NULL,
    "row" integer NOT NULL,
    "seat" integer NOT NULL,
    "hall_id" integer NOT NULL,
    "seat_category_id" integer NOT NULL,
    CONSTRAINT "rows_seats_categories_pk" PRIMARY KEY ("id")
) WITH (oids = false);

DROP TABLE IF EXISTS "seat_categories";
DROP SEQUENCE IF EXISTS seat_categories_id_seq;
CREATE SEQUENCE seat_categories_id_seq INCREMENT 1 MINVALUE 4 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."seat_categories" (
    "id" integer DEFAULT nextval('seat_categories_id_seq') NOT NULL,
    "name" text NOT NULL,
    CONSTRAINT "seat_categories_pk" PRIMARY KEY ("id")
) WITH (oids = false);

DROP TABLE IF EXISTS "sessions";
DROP SEQUENCE IF EXISTS sessions_id_seq;
CREATE SEQUENCE sessions_id_seq INCREMENT 1 MINVALUE 9 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."sessions" (
    "id" integer DEFAULT nextval('sessions_id_seq') NOT NULL,
    "datetime" timestamp NOT NULL,
    "hall_id" integer NOT NULL,
    "film_id" integer NOT NULL,
    CONSTRAINT "sessions_pk" PRIMARY KEY ("id")
) WITH (oids = false);

DROP TABLE IF EXISTS "tickets";
DROP SEQUENCE IF EXISTS tickets_id_seq;
CREATE SEQUENCE tickets_id_seq INCREMENT 1 MINVALUE 21 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."tickets" (
    "id" integer DEFAULT nextval('tickets_id_seq') NOT NULL,
    "rows_seats_categories_id" integer NOT NULL,
    "session_id" integer NOT NULL,
    "status" text NOT NULL,
    CONSTRAINT "tickets_pk" PRIMARY KEY ("id")
) WITH (oids = false);

ALTER TABLE ONLY "public"."attributes" ADD CONSTRAINT "attributes_atributes_type_id_fk" FOREIGN KEY (attribute_type_id) REFERENCES attributes_type(id) NOT DEFERRABLE;

ALTER TABLE ONLY "public"."attributes_values" ADD CONSTRAINT "attributes_values_attributes_id_fk" FOREIGN KEY (attribute_id) REFERENCES attributes(id) NOT DEFERRABLE;
ALTER TABLE ONLY "public"."attributes_values" ADD CONSTRAINT "attributes_values_films_id_fk" FOREIGN KEY (film_id) REFERENCES films(id) NOT DEFERRABLE;

ALTER TABLE ONLY "public"."prices" ADD CONSTRAINT "prices_seat_categories_id_fk" FOREIGN KEY (seat_category_id) REFERENCES seat_categories(id) NOT DEFERRABLE;
ALTER TABLE ONLY "public"."prices" ADD CONSTRAINT "prices_sessions_id_fk" FOREIGN KEY (session_id) REFERENCES sessions(id) NOT DEFERRABLE;

ALTER TABLE ONLY "public"."rows_seats_categories" ADD CONSTRAINT "rows_seats_categories_halls_id_fk" FOREIGN KEY (hall_id) REFERENCES halls(id) NOT DEFERRABLE;
ALTER TABLE ONLY "public"."rows_seats_categories" ADD CONSTRAINT "rows_seats_categories_seat_categories_id_fk" FOREIGN KEY (seat_category_id) REFERENCES seat_categories(id) NOT DEFERRABLE;

ALTER TABLE ONLY "public"."sessions" ADD CONSTRAINT "sessions_films_id_fk" FOREIGN KEY (film_id) REFERENCES films(id) NOT DEFERRABLE;
ALTER TABLE ONLY "public"."sessions" ADD CONSTRAINT "sessions_halls_id_fk" FOREIGN KEY (hall_id) REFERENCES halls(id) NOT DEFERRABLE;

ALTER TABLE ONLY "public"."tickets" ADD CONSTRAINT "tickets_rows_seats_categories_id_fk" FOREIGN KEY (rows_seats_categories_id) REFERENCES rows_seats_categories(id) NOT DEFERRABLE;
ALTER TABLE ONLY "public"."tickets" ADD CONSTRAINT "tickets_sessions_id_fk" FOREIGN KEY (session_id) REFERENCES sessions(id) NOT DEFERRABLE;

-- 2023-10-22 12:44:45.514585+00