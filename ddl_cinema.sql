CREATE TABLE `HALLS` (
    `ID` INT NOT NULL AUTO_INCREMENT,
    `NUMBER` INT NOT NULL,
    `PLACE_COUNT` INT NOT NULL,
    PRIMARY KEY (`ID`)
);

CREATE TABLE `FILMS` (
    `ID` INT NOT NULL AUTO_INCREMENT,
    `NAME` VARCHAR(255) NOT NULL,
    `YEAR` YEAR NOT NULL,
    `GENRE` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`ID`)
);

CREATE TABLE `CLIENTS` (
    `ID` INT NOT NULL AUTO_INCREMENT,
    `NAME` VARCHAR(255) NOT NULL,
    `SURNAME` VARCHAR(255) NOT NULL,
    `PHONE` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`ID`)
);

CREATE TABLE `SESSIONS` (
    `ID` INT NOT NULL AUTO_INCREMENT,
    `HALL_ID` INT NOT NULL,
    `FILM_ID` INT NOT NULL,
    `DATE_START` DATE NOT NULL,
    `TIME_START` TIME NOT NULL,
    PRIMARY KEY (`ID`),
    FOREIGN KEY (`HALL_ID`) REFERENCES `HALLS` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`FILM_ID`) REFERENCES `FILMS` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `TICKETS` (
    `ID` INT NOT NULL AUTO_INCREMENT,
    `CLIENT_ID` INT NOT NULL,
    `SESSION_ID` INT NOT NULL,
    `PLACE` INT NOT NULL,
    `PRICE` DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (`ID`),
    FOREIGN KEY (`CLIENT_ID`) REFERENCES `CLIENTS` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`SESSION_ID`) REFERENCES `SESSIONS` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
);