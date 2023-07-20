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

CREATE TABLE tariffs (
  tariff_id INT PRIMARY KEY,
  name VARCHAR(255),
  price DECIMAL(10, 2)
);

CREATE TABLE seats (
  seat_id INT PRIMARY KEY,
  hall_id INT,
  row_number INT,
  seat_number INT,
  FOREIGN KEY (hall_id) REFERENCES halls(hall_id)
);

CREATE TABLE tickets (
  ticket_id INT PRIMARY KEY,
  showtime_id INT,
  seat_id INT,
  tariff_id INT,
  customer_id INT,
  FOREIGN KEY (showtime_id) REFERENCES showtimes(showtime_id),
  FOREIGN KEY (seat_id) REFERENCES seats(seat_id),
  FOREIGN KEY (tariff_id) REFERENCES tariffs(tariff_id),
  FOREIGN KEY (customer_id) REFERENCES customers(customer_id)
);

CREATE TABLE sales (
  sale_id INT PRIMARY KEY,
  ticket_id INT,
  sale_price DECIMAL(10, 2),
  sale_date DATETIME,
  FOREIGN KEY (ticket_id) REFERENCES tickets(ticket_id)
);

SELECT 
  movies.title,
  SUM(sales.sale_price) AS total_revenue
FROM movies
JOIN showtimes ON movies.movie_id = showtimes.movie_id
JOIN tickets ON showtimes.showtime_id = tickets.showtime_id
JOIN sales ON tickets.ticket_id = sales.ticket_id
GROUP BY movies.title
ORDER BY total_revenue DESC
LIMIT 1;
