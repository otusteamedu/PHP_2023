CREATE TABLE tickets (
                         id INT PRIMARY KEY,
                         screening_id INT,
                         customer_id INT,
                         seat_id INT,
                         actual_price INT,
                         FOREIGN KEY (screening_id) REFERENCES screenings(id),
                         FOREIGN KEY (customer_id) REFERENCES customers(id),
                         FOREIGN KEY (seat_id) REFERENCES seats(id)
);