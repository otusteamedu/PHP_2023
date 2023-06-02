CREATE TABLE Halls (
  hall_id INT PRIMARY KEY,
  hall_name VARCHAR(255),
  capacity INT
);

CREATE TABLE Seats (
  seat_id INT PRIMARY KEY,
  hall_id INT,
  seat_number INT,
  row_number INT,
  FOREIGN KEY (hall_id) REFERENCES Halls(hall_id)
);

CREATE TABLE Movies (
  movie_id INT PRIMARY KEY,
  movie_title VARCHAR(255),
  director VARCHAR(255),
  release_year INT,
  genre VARCHAR(255),
  duration_minutes INT
);

CREATE TABLE Screenings (
  screening_id INT PRIMARY KEY,
  hall_id INT,
  movie_id INT,
  start_time DATETIME,
  end_time DATETIME,
  FOREIGN KEY (hall_id) REFERENCES Halls(hall_id),
  FOREIGN KEY (movie_id) REFERENCES Movies(movie_id)
);

CREATE TABLE Tickets (
  ticket_id INT PRIMARY KEY,
  screening_id INT,
  seat_id INT,
  price DECIMAL(10,2),
  FOREIGN KEY (screening_id) REFERENCES Screenings(screening_id),
  FOREIGN KEY (seat_id) REFERENCES Seats(seat_id)
);

