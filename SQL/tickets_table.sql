CREATE TABLE Tickets (
                         id INT PRIMARY KEY,
                         screening_id INT,
                         customer_id INT,
                         seat_id INT,
                         actual_price INT,
                         FOREIGN KEY (screening_id) REFERENCES Screenings(screening_id),
                         FOREIGN KEY (customer_id) REFERENCES Customers(customer_id),
                         FOREIGN KEY (seat_id) REFERENCES Seats(seat_id)
);