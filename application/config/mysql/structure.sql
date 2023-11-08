USE study;

DROP TABLE IF EXISTS films;
DROP TABLE IF EXISTS screenings;

CREATE TABLE IF NOT EXISTS films (
    id INT AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    duration INT NOT NULL,
    description VARCHAR(255) NOT NULL,
    actors VARCHAR(255) NOT NULL,
    country VARCHAR(255) NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,

    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS screenings (
    id INT auto_increment,
    film_id INT NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,

    FOREIGN KEY (film_id) REFERENCES films(id),
    PRIMARY KEY (id)
);
