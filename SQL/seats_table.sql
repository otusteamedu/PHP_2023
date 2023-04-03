CREATE TABLE Seats (
                       id INT PRIMARY KEY,
                       hall_id INT,
                       seat_number INT,
                       seat_row INT,
                       FOREIGN KEY (hall_id) REFERENCES Halls(hall_id)
);