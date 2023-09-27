/*
  Films - данные о фильмах
*/
CREATE TABLE Films (
	id SERIAL PRIMARY KEY,
	name VARCHAR(100) NOT NULL, -- Название фильма
	type VARCHAR(50) NOT NULL,  -- Тип фильма
	description TEXT NOT NULL,  -- Описание фильма 
	hours SMALLINT NOT NULL,    -- Продолжение в часах 
	minutes SMALLINT NOT NULL   -- Продолжение в минутах
);

/*
  Halls - данные о залах
*/
CREATE TABLE Halls (
  id SERIAL PRIMARY KEY,
  name VARCHAR(100) NOT NULL -- Название зала
);

/*
  TypesAreas - типы рядов (например 'стандартные', 'vip')
*/
CREATE TABLE TypesAreas (
  id SERIAL PRIMARY KEY,
  name VARCHAR(100) NOT NULL -- Название типа
);

/*
  Areas - данные о рядах (например 'ряд 1', 'A')
*/
CREATE TABLE Areas (
  id SERIAL PRIMARY KEY,
  hall_id INTEGER NOT NULL REFERENCES Halls (id), -- Зал 
  type_id INTEGER NOT NULL REFERENCES TypesAreas (id), -- Тип ряда
  name VARCHAR(100) NOT NULL  -- Назвние ряда
);

/*
  Places - данные о местах в рядах
*/
CREATE TABLE Places (
	id SERIAL PRIMARY KEY,
	area_id INTEGER NOT NULL REFERENCES Areas (id), -- Ряд
	number VARCHAR(4) NOT NULL  -- Номер места
);

/*
  Sessions - данные о сеансах 
*/
CREATE TABLE Sessions (
  id SERIAL PRIMARY KEY,
  hall_id INTEGER NOT NULL REFERENCES Halls (id), -- Зал
  film_id INTEGER NOT NULL REFERENCES Films (id), -- Фильм
  start_at TIMESTAMP NOT NULL  -- Начало сеанса
);

/*
  SessionPrices - данные о ценах на сеансы привязанные к типом рядов
*/
CREATE TABLE SessionPrices (
	session_id INTEGER NOT NULL REFERENCES Sessions (id), -- Сеанс
	type_id INTEGER NOT NULL REFERENCES TypesAreas (id), -- Тип ряда
	price DECIMAL(10, 2) NOT NULL, -- Цена
	UNIQUE (session_id, type_id)
);

/*
  Users - данные о пользователях
*/
CREATE TABLE Users (
	id SERIAL PRIMARY KEY,
	name VARCHAR(100) NOT NULL, -- Имя пользователя
	email VARCHAR(100) NOT NULL  -- Email
);

/*
  Orders - данные о заказах
*/
CREATE TABLE Orders (
	id SERIAL PRIMARY KEY,
	user_id INTEGER NOT NULL REFERENCES Users (id), -- Пользователь
	session_id INTEGER NOT NULL REFERENCES Sessions (id), -- Сеанс
	total DECIMAL(10, 2) NOT NULL  -- Общая цена
);

/*
  OrdersItems - места в заказах
*/
CREATE TABLE OrdersItems (
	order_id INTEGER NOT NULL REFERENCES Orders (id), -- Заказ
	place_id INTEGER NOT NULL REFERENCES Places (id), -- Номер места
  UNIQUE (order_id, place_id)
);
