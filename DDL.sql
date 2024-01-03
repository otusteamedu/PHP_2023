-- Залы
CREATE TABLE Halls
(
    HallID   INT PRIMARY KEY,
    HallName VARCHAR(255),
    Capacity INT
    -- Дополнительные поля по необходимости
);

-- Фильмы
CREATE TABLE Movies
(
    MovieID  INT PRIMARY KEY,
    Title    VARCHAR(255),
    Genre    VARCHAR(50),
    Director VARCHAR(100)
    -- Дополнительные поля по необходимости
);

-- Сеансы
CREATE TABLE Screenings
(
    ScreeningID INT PRIMARY KEY,
    MovieID     INT,
    HallID      INT,
    StartTime   DATETIME,
    FOREIGN KEY (MovieID) REFERENCES Movies (MovieID),
    FOREIGN KEY (HallID) REFERENCES Halls (HallID)
    -- Дополнительные поля по необходимости
);

-- Цены на сеансы
CREATE TABLE ScreeningPrices
(
    ScreeningID INT PRIMARY KEY,
    Price       DECIMAL(8, 2),
    FOREIGN KEY (ScreeningID) REFERENCES Screenings (ScreeningID)
);

-- Билеты
CREATE TABLE Tickets
(
    TicketID    INT PRIMARY KEY,
    ScreeningID INT,
    SeatNumber  INT,
    FOREIGN KEY (ScreeningID) REFERENCES Screenings (ScreeningID)
    -- Дополнительные поля по необходимости
);

SELECT Movies.Title               AS MovieTitle,
       SUM(ScreeningPrices.Price) AS TotalRevenue
FROM Movies
         JOIN
     Screenings ON Movies.MovieID = Screenings.MovieID
         JOIN
     ScreeningPrices ON Screenings.ScreeningID = ScreeningPrices.ScreeningID
GROUP BY Movies.Title
ORDER BY TotalRevenue DESC LIMIT 1;


-- Проверка свободности места на определенном сеансе

SELECT 1
FROM Tickets
WHERE ScreeningID = 10 AND SeatNumber = 15