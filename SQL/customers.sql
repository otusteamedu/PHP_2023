CREATE TABLE Customer (
                          customer_id INT AUTO_INCREMENT PRIMARY KEY,
                          first_name VARCHAR(255) NOT NULL,
                          last_name VARCHAR(255) NOT NULL,
                          email VARCHAR(255) UNIQUE NOT NULL,
                          phone VARCHAR(255) UNIQUE NOT NULL
);