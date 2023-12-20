CREATE TABLE Cinemas (
                         CinemaID INT PRIMARY KEY,
                         Name VARCHAR(100),
                         Capacity INT
);

CREATE TABLE PriceCategories (
                                 PriceCategoryID INT PRIMARY KEY,
                                 CategoryName VARCHAR(50),
                                 Price DECIMAL(10, 2)
);

-- Таблица Мест
CREATE TABLE Seats (
                       SeatID INT PRIMARY KEY,
                       CinemaID INT,
                       SeatNumber VARCHAR(10),
                       PriceCategoryID INT,
                       FOREIGN KEY (CinemaID) REFERENCES Cinemas(CinemaID),
                       FOREIGN KEY (PriceCategoryID) REFERENCES PriceCategories(PriceCategoryID)
);

-- Таблица Фильмов
CREATE TABLE Movies (
                        MovieID INT PRIMARY KEY,
                        Title VARCHAR(100),
                        Duration INT,
                        Director VARCHAR(100)
);

-- Таблица Сеансов
CREATE TABLE Showtimes (
                           ShowtimeID INT PRIMARY KEY,
                           CinemaID INT,
                           MovieID INT,
                           ShowType VARCHAR(50), -- Например, 'обычный', '3D', 'IMAX'
                           StartTime timestamp,
                           EndTime timestamp,
                           FOREIGN KEY (CinemaID) REFERENCES Cinemas(CinemaID),
                           FOREIGN KEY (MovieID) REFERENCES Movies(MovieID)
);

-- Таблица Клиентов
CREATE TABLE Customers (
                           CustomerID INT PRIMARY KEY,
                           Name VARCHAR(100),
                           Email VARCHAR(100)
);

-- Таблица Билетов
CREATE TABLE Tickets (
                         TicketID INT PRIMARY KEY,
                         ShowtimeID INT,
                         SeatID INT,
                         CustomerID INT,
                         Price DECIMAL(10, 2),
                         FOREIGN KEY (ShowtimeID) REFERENCES Showtimes(ShowtimeID),
                         FOREIGN KEY (SeatID) REFERENCES Seats(SeatID),
                         FOREIGN KEY (CustomerID) REFERENCES Customers(CustomerID)
);