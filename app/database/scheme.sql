CREATE TABLE IF NOT EXISTS application_form (
   id INT AUTO_INCREMENT PRIMARY KEY,
   email VARCHAR(255) NOT NULL,
   message VARCHAR(255) NOT NULL
)  ENGINE=INNODB;
