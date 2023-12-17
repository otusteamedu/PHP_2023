CREATE TABLE Movies
(
    ID          SERIAL PRIMARY KEY,
    Title       VARCHAR(255) NOT NULL,
    Genre       VARCHAR(50),
    ReleaseDate DATE,
    Director    VARCHAR(100),
    Description TEXT
);

-- Таблица "Залы"
CREATE TABLE Halls
(
    ID       SERIAL PRIMARY KEY,
    Name     VARCHAR(50) NOT NULL,
    Capacity INT         NOT NULL,
    Layout   TEXT
);

-- Таблица "Сеансы"
CREATE TABLE Sessions
(
    ID        SERIAL PRIMARY KEY,
    MovieID   INT REFERENCES Movies (ID),
    HallID    INT REFERENCES Halls (ID),
    StartTime TIMESTAMP     NOT NULL,
    EndTime   TIMESTAMP     NOT NULL,
    Price     DECIMAL(8, 2) NOT NULL
);

-- Таблица "Билеты"
CREATE TABLE Tickets
(
    ID         SERIAL PRIMARY KEY,
    SessionID  INT REFERENCES Sessions (ID),
    SeatNumber INT NOT NULL,
    IsReserved BOOLEAN DEFAULT FALSE
);


SELECT
    M.Title AS MovieTitle,
    SUM(S.Price) AS TotalRevenue
FROM
    Movies M
        JOIN
    Sessions S ON M.ID = S.MovieID
        JOIN
    Tickets T ON S.ID = T.SessionID
GROUP BY
    M.Title
ORDER BY
    TotalRevenue DESC
    LIMIT 1;