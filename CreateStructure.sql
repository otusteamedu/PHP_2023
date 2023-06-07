CREATE DATABASE cinema;
USE cinema;

CREATE TABLE Halls (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(255),
    seatsNumber INT,
    PRIMARY KEY (`id`)
);

CREATE TABLE Films (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(255),
    cost INT,
    duration TIME,
    PRIMARY KEY (`id`)
);


CREATE TABLE Sessions (
    id INT(11) NOT NULL AUTO_INCREMENT,
    hallId INT,
    filmId INT,
    beginTime DATETIME,
    PRIMARY KEY (`id`),
    FOREIGN KEY (hallId)  REFERENCES Halls (Id),
    FOREIGN KEY (filmId)  REFERENCES Films (Id)
);


CREATE TABLE soldTickets (
    id INT(11) NOT NULL AUTO_INCREMENT,
    sessionId INT,
    seatNumber INT,
    clientFio VARCHAR(255),
    PRIMARY KEY (`id`),
    FOREIGN KEY (sessionId)  REFERENCES Sessions (Id)
);