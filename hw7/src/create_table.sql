-- Database: postgres

DROP TABLE IF EXISTS TicketSale;
DROP TABLE IF EXISTS ShowFilm;
DROP TABLE IF EXISTS TicketPrice ;
DROP TABLE IF EXISTS ZhanrFilm;
DROP TABLE IF EXISTS Show;
DROP TABLE IF EXISTS Room;
DROP TABLE IF EXISTS Film;
DROP TABLE IF EXISTS Zhanr;


CREATE TABLE Film (
  id SERIAL PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  long INT NOT NULL DEFAULT 1
);

CREATE TABLE Room (
  id SERIAL PRIMARY KEY,
  name VARCHAR(100) NOT NULL
);

CREATE TABLE Show (
  id SERIAL PRIMARY KEY,
  time_start CHAR(5) NOT NULL
);

CREATE TABLE zhanr (
   id SERIAL PRIMARY KEY,
   name VARCHAR(255) NOT NULL
);

CREATE TABLE zhanrfilm (
    id SERIAL PRIMARY KEY,
    id_film INT NOT NULL,
    id_zhanr INT NOT NULL
);
CREATE UNIQUE INDEX zhanrfilm_u ON zhanrfilm (id_film, id_zhanr);

CREATE TABLE ticketprice (
  id SERIAL PRIMARY KEY,
  id_room INT NOT NULL,
  line INT NOT NULL,
  id_show INT NOT NULL,
  weekday INT NOT NULL,
  price INT NOT NULL,
  FOREIGN KEY (id_room)
      REFERENCES Room (id) ON UPDATE SET NULL ON DELETE CASCADE,
  FOREIGN KEY (id_show)
      REFERENCES Show (id) ON UPDATE SET NULL ON DELETE CASCADE
);
CREATE UNIQUE INDEX ticketprice_u ON ticketprice (id_room, line, id_show, weekday);

CREATE TABLE showfilm (
  id SERIAL PRIMARY KEY,
  id_room INT NOT NULL,
  id_show INT NOT NULL,
  id_film INT NOT NULL,
  data TIMESTAMP ,
  FOREIGN KEY (id_room)
      REFERENCES Room (id) ON UPDATE SET NULL ON DELETE CASCADE,
  FOREIGN KEY (id_show)
      REFERENCES Show (id) ON UPDATE SET NULL ON DELETE CASCADE,
  FOREIGN KEY (id_film)
      REFERENCES Film (id) ON UPDATE SET NULL ON DELETE CASCADE
);
CREATE UNIQUE INDEX showfilm_u ON showfilm (id_room, id_show, id_film);

CREATE TABLE ticketsale (
  id SERIAL PRIMARY KEY,
  id_show_film INT NOT NULL,
  line INT NOT NULL,
  place INT NOT NULL,
  data TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
  FOREIGN KEY (id_show_film)
      REFERENCES ShowFilm (id) ON UPDATE SET NULL ON DELETE CASCADE
);
CREATE UNIQUE INDEX ticketsale_u ON ticketsale (id_show_film, line, place);
