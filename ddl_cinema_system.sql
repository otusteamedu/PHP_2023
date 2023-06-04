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

DROP TABLE IF EXISTS type_place;
CREATE TABLE type_place (
                        "id" serial PRIMARY KEY,
                         "name" varchar(60) NOT NULL
);

DROP TABLE IF EXISTS cashiers;
CREATE TABLE cashiers (
                         "id" serial PRIMARY KEY,
                         "full_name" varchar(60) NOT NULL
);

DROP TABLE IF EXISTS places;
CREATE TABLE places (
                        "id" serial PRIMARY KEY,
                        "row" Smallint NOT NULL,
                        "position" Smallint NOT NULL,
                        "hall_id" integer NOT NULL,
                        "type_place_id" integer NOT NULL,
                        FOREIGN KEY (hall_id) REFERENCES halls(id) ON DELETE CASCADE,
                        FOREIGN KEY (type_place_id) REFERENCES type_place(id) ON DELETE CASCADE
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

DROP TABLE IF EXISTS prices;
CREATE TABLE prices (
                         "id" serial PRIMARY KEY,
                         "place_id" integer NOT NULL,
                         "session_id" integer NOT NULL,
                         "price" integer NOT NULL,
                         FOREIGN KEY (session_id) REFERENCES sessions(id) ON DELETE CASCADE,
                         FOREIGN KEY (place_id) REFERENCES places(id) ON DELETE CASCADE
);

DROP TABLE IF EXISTS tickets;
CREATE TABLE tickets (
                         "id" serial PRIMARY KEY,
                         "client_id" integer NOT NULL,
                         "session_id" integer NOT NULL,
                         "cashier_id" integer NOT NULL,
                         "buyed_at" timestamp NOT NULL,
                         "place_id" numeric NOT NULL,
                         FOREIGN KEY (session_id) REFERENCES sessions(id) ON DELETE CASCADE,
                         FOREIGN KEY (cashier_id) REFERENCES cashiers(id) ON DELETE CASCADE,
                         FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE,
                         FOREIGN KEY (place_id) REFERENCES places(id) ON DELETE CASCADE
);
