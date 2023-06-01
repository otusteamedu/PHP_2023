DROP TABLE IF EXISTS films;
CREATE TABLE films (
                       "id" serial PRIMARY KEY,
                       "title" varchar(255) NOT NULL,
                       "description" TEXT NOT NULL,
                       "poster" varchar(255) NOT NULL,
                       "premier_date" DATE NULL
);

DROP TABLE IF EXISTS clients;
CREATE TABLE clients (
                         "id" serial PRIMARY KEY,
                         "name" varchar(60) NOT NULL,
                         "phone"  varchar(20) NOT NULL UNIQUE,
                         "email"  varchar(60) NOT NULL UNIQUE
);

DROP TABLE IF EXISTS halls;
CREATE TABLE halls (
                       "id" serial PRIMARY KEY,
                       "number" Smallint NOT NULL,
                       "places_count" smallint not null
);

DROP TABLE IF EXISTS places;
CREATE TABLE places (
                        "id" serial PRIMARY KEY,
                        "column" Smallint NOT NULL,
                        "position" Smallint NOT NULL,
                        "hall_id" integer NOT NULL,
                        FOREIGN KEY (hall_id) REFERENCES halls(id) ON DELETE CASCADE,
                        UNIQUE ("column", "position", "hall_id")
);

DROP TABLE IF EXISTS sessions;
CREATE TABLE sessions (
                          "id" serial PRIMARY KEY,
                          "hall_id" integer NOT NULL,
                          "film_id" integer NOT NULL,
                          "started_at" time NOT NULL,
                          "ended_at" time NOT NULL,
                          FOREIGN KEY (hall_id) REFERENCES halls(id) ON DELETE CASCADE,
                          FOREIGN KEY (film_id) REFERENCES films(id) ON DELETE CASCADE
);

DROP TABLE IF EXISTS tickets;
CREATE TABLE tickets (
                         "id" serial PRIMARY KEY,
                         "session_id" integer NOT NULL,
                         "place_id" integer NOT NULL,
                         "client_id" integer NOT NULL,
                         "buyed_at" timestamp NOT NULL,
                         "price" numeric NOT NULL,
                         FOREIGN KEY (session_id) REFERENCES sessions(id) ON DELETE CASCADE,
                         FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE,
                         FOREIGN KEY (place_id) REFERENCES places(id) ON DELETE CASCADE,
                         UNIQUE ("session_id", "place_id")
);