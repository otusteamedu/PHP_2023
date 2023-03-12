
CREATE TABLE halls (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    number INT UNSIGNED NOT NULL,
    capacity INT UNSIGNED NOT NULL
);

CREATE TABLE `rows` (
      id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
      number INT UNSIGNED NOT NULL,
      hall_id INT UNSIGNED NOT NULL,
      CONSTRAINT c_fk_rows_hall FOREIGN KEY (hall_id) REFERENCES halls (id) ON DELETE RESTRICT
);

CREATE TABLE places (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    number INT UNSIGNED NOT NULL,
    price INT UNSIGNED NOT NULL,
    row_id INT UNSIGNED NOT NULL,
    CONSTRAINT c_fk_row FOREIGN KEY (row_id) REFERENCES `rows` (id) ON DELETE RESTRICT
);

CREATE TABLE films (
   id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
   name VARCHAR(256) NOT NULL,
   release_date DATE NOT NULL,
   country_production VARCHAR(50) NOT NULL,
   duration INT UNSIGNED NOT NULL,
   description TEXT
);

CREATE TABLE customers (
   id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
   user_name VARCHAR(50) NOT NULL,
   email VARCHAR(50) NOT NULL,
   birthday DATE,
   first_name VARCHAR(50),
   last_name VARCHAR(50)
);

CREATE TABLE sessions (
   id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
   date_start DATETIME NOT NULL,
   date_end DATETIME NOT NULL,
   hall_id INT UNSIGNED NOT NULL,
   film_id INT UNSIGNED NOT NULL,
   CONSTRAINT c_fk_hall FOREIGN KEY (hall_id) REFERENCES halls (id) ON DELETE RESTRICT,
   CONSTRAINT c_fk_film FOREIGN KEY (film_id) REFERENCES films (id) ON DELETE RESTRICT
);

CREATE TABLE tickets (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  price INT UNSIGNED NOT NULL,
  payed BOOL DEFAULT FALSE,
  purchase_date DATETIME,
  row_id INT UNSIGNED NOT NULL,
  place_id INT UNSIGNED NOT NULL,
  session_id INT UNSIGNED NOT NULL,
  customer_id INT UNSIGNED NOT NULL,
  CONSTRAINT c_fk_ticket_row FOREIGN KEY (row_id) REFERENCES `rows` (id) ON DELETE RESTRICT,
  CONSTRAINT c_fk_ticket_place FOREIGN KEY (place_id) REFERENCES places (id) ON DELETE RESTRICT,
  CONSTRAINT c_fk_session FOREIGN KEY (session_id) REFERENCES sessions (id) ON DELETE RESTRICT,
  CONSTRAINT c_fk_customer FOREIGN KEY (customer_id) REFERENCES customers (id) ON DELETE RESTRICT
);
