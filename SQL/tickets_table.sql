CREATE TABLE Ticket (
                        ticket_id INT AUTO_INCREMENT PRIMARY KEY,
                        customer_id INT,
                        screening_id INT,
                        seat_number INT NOT NULL,
                        FOREIGN KEY (customer_id) REFERENCES Customer(customer_id),
                        FOREIGN KEY (screening_id) REFERENCES Screening(screening_id)
);