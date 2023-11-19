/*
  Films - данные о фильмах
*/
CREATE TABLE Films (
	id SERIAL PRIMARY KEY,
	name VARCHAR(100) NOT NULL UNIQUE, -- Название фильма
  type VARCHAR(50) NOT NULL, -- Тип фильма 
	description TEXT NOT NULL  -- Описание фильма
);

CREATE TYPE types_attributes AS ENUM ('int', 'string', 'text', 'float', 'datetime', 'date', 'bool');

/*
  Attributes
*/
CREATE TABLE Attributes (
	id SERIAL PRIMARY KEY,
	name VARCHAR(100) NOT NULL UNIQUE,
  type types_attributes NOT NULL
);

/*
  Values
*/
CREATE TABLE AttributeValues (
	film_id INTEGER REFERENCES Films (id),
  attribute_id INTEGER REFERENCES Attributes (id),
  int_value INTEGER NULL,
  string_value VARCHAR NULL,
  text_value TEXT NULL,
  float_value NUMERIC(18, 2),
  datetime_value TIMESTAMP NULL,
  date_value DATE NULL,
  bool_value BOOLEAN NULL
);

CREATE INDEX idx_attribute_value_film ON AttributeValues (film_id, attribute_id);

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
CREATE TABLE TypesRows (
  id SERIAL PRIMARY KEY,
  name VARCHAR(100) NOT NULL -- Название типа
);

/*
  Areas - Данные о облости в зале.(Для отрисовки зала)
*/
CREATE TABLE Rows (
  id SERIAL PRIMARY KEY,
  type_id INTEGER NOT NULL REFERENCES TypesRows (id), -- Тип ряда
  title VARCHAR(100) NOT NULL,  -- Назвние ряда
  hall_id INTEGER NOT NULL REFERENCES Halls (id),
  position SMALLINT NOT NULL
);

/*
  Places - данные о местах в рядах
*/
CREATE TABLE Places (
	id SERIAL PRIMARY KEY,
	row_id INTEGER NOT NULL REFERENCES Rows (id), -- Ряд
	number VARCHAR(4) NOT NULL,  -- Номер места
  active SMALLINT DEFAULT 1
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

CREATE INDEX idx_sessions_start_at ON sessions (start_at);

/*
  SessionPrices - данные о ценах на сеансы привязанные к типом рядов
*/
CREATE TABLE SessionPrices (
	session_id INTEGER NOT NULL REFERENCES Sessions (id), -- Сеанс
	type_id INTEGER NOT NULL REFERENCES TypesRows (id), -- Тип ряда
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


CREATE TYPE status_order AS ENUM ('booked', 'purchased', 'cancelled');
/*
  Orders - данные о заказах
*/
CREATE TABLE Orders (
	id SERIAL PRIMARY KEY,
	user_id INTEGER NOT NULL REFERENCES Users (id), -- Пользователь
	session_id INTEGER NOT NULL REFERENCES Sessions (id), -- Сеанс
  place_id INTEGER NOT NULL REFERENCES Places (id), -- Номер места
	price DECIMAL(10, 2) NOT NULL,  -- цена
  status status_order,
  created_at TIMESTAMP NOT NULL,
  updated_at TIMESTAMP NULL
);