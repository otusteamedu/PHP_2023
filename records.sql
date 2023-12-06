-- Заполнение таблицы Кинозалов
INSERT INTO Cinemas (CinemaID, Name, Capacity) VALUES (1, 'Зал 1', 100);
INSERT INTO Cinemas (CinemaID, Name, Capacity) VALUES (2, 'Зал 2', 150);
INSERT INTO Cinemas (CinemaID, Name, Capacity) VALUES (3, 'Зал 3', 200);
INSERT INTO Cinemas (CinemaID, Name, Capacity) VALUES (4, 'Зал 4', 120);

-- Заполнение таблицы Фильмов
INSERT INTO Movies (MovieID, Title, Duration, Director) VALUES (1, 'Космические Рейнджеры', 120, 'Иван Иванов');
INSERT INTO Movies (MovieID, Title, Duration, Director) VALUES (2, 'Приключения в Джунглях', 90, 'Мария Петрова');
INSERT INTO Movies (MovieID, Title, Duration, Director) VALUES (3, 'Глубокий Океан', 110, 'Сергей Сидоров');
INSERT INTO Movies (MovieID, Title, Duration, Director) VALUES (4, 'Город Героев', 95, 'Анна Кузнецова');

-- Заполнение таблицы Ценовых Категорий
INSERT INTO PriceCategories (PriceCategoryID, CategoryName, Price) VALUES (1, 'Стандарт', 250.00);
INSERT INTO PriceCategories (PriceCategoryID, CategoryName, Price) VALUES (2, 'VIP', 500.00);
INSERT INTO PriceCategories (PriceCategoryID, CategoryName, Price) VALUES (3, 'Детский', 150.00);
INSERT INTO PriceCategories (PriceCategoryID, CategoryName, Price) VALUES (4, 'Льготный', 200.00);

-- Заполнение таблицы Мест
-- Предполагаем, что в каждом зале по 4 места для простоты
INSERT INTO Seats (SeatID, CinemaID, SeatNumber, PriceCategoryID) VALUES (1, 1, 'A1', 1);
INSERT INTO Seats (SeatID, CinemaID, SeatNumber, PriceCategoryID) VALUES (2, 1, 'A2', 2);
INSERT INTO Seats (SeatID, CinemaID, SeatNumber, PriceCategoryID) VALUES (3, 2, 'B1', 3);
INSERT INTO Seats (SeatID, CinemaID, SeatNumber, PriceCategoryID) VALUES (4, 2, 'B2', 4);

-- Заполнение таблицы Сеансов
INSERT INTO Showtimes (ShowtimeID, CinemaID, MovieID, ShowType, StartTime, EndTime) VALUES (1, 1, 1, 'обычный', '2023-01-01 14:00', '2023-01-01 16:00');
INSERT INTO Showtimes (ShowtimeID, CinemaID, MovieID, ShowType, StartTime, EndTime) VALUES (2, 2, 2, '3D', '2023-01-01 17:00', '2023-01-01 18:30');
INSERT INTO Showtimes (ShowtimeID, CinemaID, MovieID, ShowType, StartTime, EndTime) VALUES (3, 3, 3, 'IMAX', '2023-01-01 19:00', '2023-01-01 20:50');
INSERT INTO Showtimes (ShowtimeID, CinemaID, MovieID, ShowType, StartTime, EndTime) VALUES (4, 4, 4, 'обычный', '2023-01-01 21:00', '2023-01-01 22:35');

-- Заполнение таблицы Клиентов
INSERT INTO Customers (CustomerID, Name, Email) VALUES (1, 'Алексей', 'aleksey@example.com');
INSERT INTO Customers (CustomerID, Name, Email) VALUES (2, 'Елена', 'elena@example.com');
INSERT INTO Customers (CustomerID, Name, Email) VALUES (3, 'Дмитрий', 'dmitriy@example.com');
INSERT INTO Customers (CustomerID, Name, Email) VALUES (4, 'Ольга', 'olga@example.com');

-- Заполнение таблицы Билетов
INSERT INTO Tickets (TicketID, ShowtimeID, SeatID, CustomerID, Price) VALUES (1, 1, 1, 1, 250.00);
INSERT INTO Tickets (TicketID, ShowtimeID, SeatID, CustomerID, Price) VALUES (2, 2, 2, 2, 500.00);
INSERT INTO Tickets (TicketID, ShowtimeID, SeatID, CustomerID, Price) VALUES (3, 3, 3, 3, 150.00);
INSERT INTO Tickets (TicketID, ShowtimeID, SeatID, CustomerID, Price) VALUES (4, 4, 4, 4, 200.00);