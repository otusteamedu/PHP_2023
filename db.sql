 CREATE TABLE cinemas (
  cinema_id INT PRIMARY KEY,
  name VARCHAR(255),
  location VARCHAR(255)
);

CREATE TABLE halls (
  hall_id INT PRIMARY KEY,
  name VARCHAR(255),
  capacity INT,
  cinema_id INT,
  FOREIGN KEY (cinema_id) REFERENCES cinemas(cinema_id)
);

CREATE TABLE movies (
  movie_id INT PRIMARY KEY,
  title VARCHAR(255),
  genre VARCHAR(255),
  duration INT,
  rating VARCHAR(255)
);

CREATE TABLE showtimes (
  showtime_id INT PRIMARY KEY,
  hall_id INT,
  movie_id INT,
  start_time DATETIME,
  end_time DATETIME,
  FOREIGN KEY (hall_id) REFERENCES halls(hall_id),
  FOREIGN KEY (movie_id) REFERENCES movies(movie_id)
);

CREATE TABLE customers (
  customer_id INT PRIMARY KEY,
  name VARCHAR(255),
  email VARCHAR(255),
  phone_number VARCHAR(255)
);

CREATE TABLE tickets (
  ticket_id INT PRIMARY KEY,
  showtime_id INT,
  customer_id INT,
  seat_number VARCHAR(255),
  price DECIMAL(10,2),
  FOREIGN KEY (showtime_id) REFERENCES showtimes(showtime_id),
  FOREIGN KEY (customer_id) REFERENCES customers(customer_id)
);
