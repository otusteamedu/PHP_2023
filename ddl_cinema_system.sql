DROP TYPE IF EXISTS day;
CREATE TYPE day AS ENUM ('monday', 'thuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday');

DROP TABLE IF EXISTS films;
CREATE TABLE films (
                       "id" serial PRIMARY KEY,
                       "title" varchar(255) NOT NULL,
                       "description" TEXT NOT NULL,
                       "poster" varchar(255) NOT NULL,
                       "premier_date" DATE NULL,
                       "duration" integer NOT NULL
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
                       "name" varchar(100) NOT NULL,
                       "places_count" smallint not null
);

INSERT INTO halls (id, name, places_count) VALUES (1, 'Детский', 100);
INSERT INTO halls (id, name, places_count) VALUES (2, 'Взрослый', 100);
INSERT INTO halls (id, name, places_count) VALUES (3, 'Еврейский', 75);
INSERT INTO halls (id, name, places_count) VALUES (4, 'Imax', 75);



DROP TABLE IF EXISTS type_place;
CREATE TABLE type_place (
                        "id" serial PRIMARY KEY,
                         "name" varchar(60) NOT NULL
);

INSERT INTO type_place (id, name) VALUES (1, 'vip');
INSERT INTO type_place (id, name) VALUES (2, 'luxe');
INSERT INTO type_place (id, name) VALUES (3, 'normal');



DROP TABLE IF EXISTS cashiers;
CREATE TABLE cashiers (
                         "id" serial PRIMARY KEY,
                         "full_name" varchar(60) NOT NULL
);

INSERT INTO cashiers (id, full_name) VALUES (1, 'Света');
INSERT INTO cashiers (id, full_name) VALUES (2, 'Таня');
INSERT INTO cashiers (id, full_name) VALUES (3, 'Наташа');
INSERT INTO cashiers (id, full_name) VALUES (4, 'Гульчачак');



DROP TABLE IF EXISTS places;
CREATE TABLE places (
                        "id" serial PRIMARY KEY,
                        "row" smallint NOT NULL,
                        "position" smallint NOT NULL,
                        "hall_id" integer NOT NULL,
                        "type_place_id" integer NOT NULL,
                        FOREIGN KEY (hall_id) REFERENCES halls(id) ON DELETE CASCADE,
                        FOREIGN KEY (type_place_id) REFERENCES type_place(id) ON DELETE CASCADE
);


DROP TABLE IF EXISTS prices;
CREATE TABLE prices (
                         "id" serial PRIMARY KEY,
                         "price" integer NOT NULL
);


DROP TABLE IF EXISTS sessions;
CREATE TABLE sessions (
                          "id" serial PRIMARY KEY,
                          "hall_id" integer NOT NULL,
                          "film_id" integer NOT NULL,
                          "price_id" integer NOT NULL,
                          "time" time NOT NULL,
                          "date" DATE NOT NULL,
                          "year" smallint NOT NULL,
                          FOREIGN KEY (price_id) REFERENCES prices(id) ON DELETE CASCADE,
                          FOREIGN KEY (hall_id) REFERENCES halls(id) ON DELETE CASCADE,
                          FOREIGN KEY (film_id) REFERENCES films(id) ON DELETE CASCADE
);



DROP TABLE IF EXISTS tickets;
CREATE TABLE tickets (
                         "id" serial PRIMARY KEY,
                         "client_id" integer NOT NULL,
                         "session_id" integer NOT NULL,
                         "cashier_id" integer NOT NULL,
                         "buyed_at" timestamp NOT NULL,
                         "place_id" integer NOT NULL,
                         FOREIGN KEY (session_id) REFERENCES sessions(id) ON DELETE CASCADE,
                         FOREIGN KEY (cashier_id) REFERENCES cashiers(id) ON DELETE CASCADE,
                         FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE,
                        FOREIGN KEY (place_id) REFERENCES places(id) ON DELETE CASCADE
);
