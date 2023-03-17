
-- Типы рейтингов фильмов;
CREATE TYPE public.movie_rating AS ENUM (
    'G',
    'PG',
    'PG-13',
    'R',
    'NC-17'
);

-- Кинотеатры заказчика;
CREATE SEQUENCE cinema_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "public"."cinema" (
    "id" integer DEFAULT nextval('cinema_id_seq') NOT NULL,
    "name" character varying(128) NOT NULL,
    "address" character varying(512) NOT NULL,
    "working_hours_start" time without time zone,
    "working_hours_end" time without time zone,
    "base_ticket_price" integer NOT NULL,
    "imax_margin" smallint NOT NULL,
    "vip_margin" smallint NOT NULL,
    CONSTRAINT "cinema_id" PRIMARY KEY ("id")
);

-- Клиенты кинотеатра;
CREATE SEQUENCE client_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "public"."client" (
    "id" integer DEFAULT nextval('client_id_seq') NOT NULL,
    "phone" character varying(20) NOT NULL,
    "name" character varying(256) NOT NULL,
    "birthday" date NOT NULL,
    "create_date" timestamp DEFAULT now() NOT NULL,
    CONSTRAINT "client_id" PRIMARY KEY ("id"),
    CONSTRAINT "client_phone" UNIQUE ("phone")
);

CREATE INDEX "client_birthday" ON "public"."client" USING btree ("birthday");

CREATE INDEX "client_name" ON "public"."client" USING btree ("name");

-- Залы кинотеатра;
CREATE SEQUENCE hall_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "public"."hall" (
    "id" integer DEFAULT nextval('hall_id_seq') NOT NULL,
    "cinema_id" integer NOT NULL,
    "name" character varying(128) NOT NULL,
    "3d" boolean NOT NULL,
    "imax" boolean NOT NULL,
    CONSTRAINT "hall_id" PRIMARY KEY ("id"),
    CONSTRAINT "hall_cinema_id_fkey" FOREIGN KEY (cinema_id) REFERENCES cinema(id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE
);

CREATE INDEX "hall_name" ON "public"."hall" USING btree ("name");

-- Фильмы;
CREATE SEQUENCE movie_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "public"."movie" (
    "id" integer DEFAULT nextval('movie_id_seq') NOT NULL,
    "name" character varying(256) NOT NULL,
    "description" text NOT NULL,
    "thumbnail" character varying(512) NOT NULL,
    "poster" character varying(512) NOT NULL,
    "rating" movie_rating NOT NULL,
    "duration" smallint NOT NULL,
    "rent_date_start" date NOT NULL,
    "rent_date_end" date NOT NULL,
    "release_date" date NOT NULL,
    CONSTRAINT "movie_id" PRIMARY KEY ("id")
);

CREATE INDEX "movie_name" ON "public"."movie" USING btree ("name");

CREATE INDEX "movie_release_date" ON "public"."movie" USING btree ("release_date");

-- Места в зале;
CREATE SEQUENCE seat_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "public"."seat" (
    "id" integer DEFAULT nextval('seat_id_seq') NOT NULL,
    "number" smallint NOT NULL,
    "row" smallint NOT NULL,
    "vip" boolean NOT NULL,
    "hall_id" integer NOT NULL,
    CONSTRAINT "seat_id" PRIMARY KEY ("id"),
    CONSTRAINT "seat_number_row_hall_id" UNIQUE ("number", "row", "hall_id"),
    CONSTRAINT "seat_hall_id_fkey" FOREIGN KEY (hall_id) REFERENCES hall(id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE
);

-- Сеансы фильмов;
CREATE SEQUENCE session_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "public"."session" (
    "id" integer DEFAULT nextval('session_id_seq') NOT NULL,
    "movie_id" integer NOT NULL,
    "hall_id" integer NOT NULL,
    "date" date NOT NULL,
    "end_time" time without time zone NOT NULL,
    "session_period_id" integer NOT NULL,
    CONSTRAINT "session_id" PRIMARY KEY ("id"),
    CONSTRAINT "session_hall_id_fkey" FOREIGN KEY (hall_id) REFERENCES hall(id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE,
    CONSTRAINT "session_movie_id_fkey" FOREIGN KEY (movie_id) REFERENCES movie(id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE,
    CONSTRAINT "session_session_period_id_fkey" FOREIGN KEY (session_period_id) REFERENCES session_period(id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE
);

-- Типы сеансов по времени;
CREATE SEQUENCE session_period_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "public"."session_period" (
    "id" integer DEFAULT nextval('session_period_id_seq') NOT NULL,
    "start_time" time without time zone NOT NULL,
    "margin" smallint NOT NULL,
    CONSTRAINT "session_period_id" PRIMARY KEY ("id")
);

-- Билеты;
CREATE SEQUENCE ticket_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 1 CACHE 1;

CREATE TABLE "public"."ticket" (
    "id" integer DEFAULT nextval('ticket_id_seq') NOT NULL,
    "session_id" integer NOT NULL,
    "seat_id" integer NOT NULL,
    "client_id" integer,
    "price" integer NOT NULL,
    "create_date" timestamp DEFAULT now() NOT NULL,
    "confirmed" boolean DEFAULT false NOT NULL,
    CONSTRAINT "ticket_id" PRIMARY KEY ("id"),
    CONSTRAINT "ticket_session_id_seat_id" UNIQUE ("session_id", "seat_id"),
    CONSTRAINT "ticket_client_id_fkey" FOREIGN KEY (client_id) REFERENCES client(id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE,
    CONSTRAINT "ticket_seat_id_fkey" FOREIGN KEY (seat_id) REFERENCES seat(id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE,
    CONSTRAINT "ticket_session_id_fkey" FOREIGN KEY (session_id) REFERENCES session(id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE
);

CREATE INDEX "ticket_confirmed" ON "public"."ticket" USING btree ("confirmed");