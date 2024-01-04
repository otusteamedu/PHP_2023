-- Кинотеатры
CREATE TABLE cinema (
    id SERIAL PRIMARY KEY,
    name VARCHAR(64)
);

-- Залы
CREATE TABLE room (
    id SERIAL PRIMARY KEY,
    cinema_id INT NOT NULL,
    name VARCHAR(64),
    FOREIGN KEY (cinema_id) REFERENCES cinema(id)
);

-- Типы мест
CREATE TABLE seattype (
    id SERIAL PRIMARY KEY,
    name VARCHAR(64)
);

-- Места
CREATE TABLE seat (
    id SERIAL PRIMARY KEY,
    room_id INT NOT NULL,
    seattype_id INT NOT NULL,
    line INT,
    number INT,
    FOREIGN KEY (room_id) REFERENCES room(id),
    FOREIGN KEY (seattype_id) REFERENCES seattype(id)
);

-- Карточки цен
CREATE TABLE price (
    id SERIAL PRIMARY KEY,
    name VARCHAR(64)
);

-- Детализация цен
CREATE TABLE priceitem (
    id SERIAL PRIMARY KEY,
    price_id INT NOT NULL,
    seattype_id INT NOT NULL,
    price NUMERIC(6,2),
    FOREIGN KEY (price_id) REFERENCES price(id),
    FOREIGN KEY (seattype_id) REFERENCES seattype(id)
);

-- Фильмы
CREATE TABLE movie (
    id SERIAL PRIMARY KEY,
    name VARCHAR(128),
    release DATE,
    length INT
);

-- Сеансы
CREATE TABLE show (
    id SERIAL PRIMARY KEY,
    room_id INT NOT NULL,
    movie_id INT NOT NULL,
    price_id INT NOT NULL,
    schedule TIMESTAMP WITH TIME ZONE,
    FOREIGN KEY (room_id) REFERENCES room(id),
    FOREIGN KEY (movie_id) REFERENCES movie(id),
    FOREIGN KEY (price_id) REFERENCES price(id)  
);

-- Покупатели
CREATE TABLE client (
    id SERIAL PRIMARY KEY,
    name VARCHAR(64)
);

-- Заказы
CREATE TABLE ticket (
    id SERIAL PRIMARY KEY,
    show_id INT NOT NULL,
    seat_id INT NOT NULL,
    client_id INT,
    price NUMERIC(8,2),
    FOREIGN KEY (show_id) REFERENCES show(id),
    FOREIGN KEY (client_id) REFERENCES client(id),
    FOREIGN KEY (seat_id) REFERENCES seat(id)
);
