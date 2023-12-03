# Сущности:
Cinemas - информация о кинотеатрах.
Halls - залы внутри каждого кинотеатра.
Movies - фильмы, которые идут в кинотеатре.
Sessions - сеансы, на которые клиенты могут купить билеты.
Seats - места в зале.
Tickets - билеты, приобретенные на сеансы.
Prices - стоимость билетов.


# Схема
```sql
CREATE TABLE cinemas (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    address TEXT NOT NULL
);

CREATE TABLE halls (
    id SERIAL PRIMARY KEY,
    cinema_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    capacity INT NOT NULL,
    CONSTRAINT fk_cinema FOREIGN KEY (cinema_id) REFERENCES cinemas(id)
);

CREATE TABLE movies (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    duration INT NOT NULL,
    release_date DATE NOT NULL
);

CREATE TABLE sessions (
    id SERIAL PRIMARY KEY,
    hall_id INT NOT NULL,
    movie_id INT NOT NULL,
    start_time TIMESTAMP NOT NULL,
    CONSTRAINT fk_hall FOREIGN KEY (hall_id) REFERENCES halls(id),
    CONSTRAINT fk_movie FOREIGN KEY (movie_id) REFERENCES movies(id)
);

CREATE TABLE seats (
    id SERIAL PRIMARY KEY,
    hall_id INT NOT NULL,
    row_number INT NOT NULL,
    seat_number INT NOT NULL,
    CONSTRAINT fk_hall_seats FOREIGN KEY (hall_id) REFERENCES halls(id)
);

CREATE TABLE tickets (
    id SERIAL PRIMARY KEY,
    session_id INT NOT NULL,
    seat_id INT NOT NULL,
    price NUMERIC(10, 2) NOT NULL,
    CONSTRAINT fk_session FOREIGN KEY (session_id) REFERENCES sessions(id),
    CONSTRAINT fk_seat FOREIGN KEY (seat_id) REFERENCES seats(id)
);

CREATE TABLE price_categories (
                                  id SERIAL PRIMARY KEY,
                                  name VARCHAR(255) NOT NULL,
                                  description TEXT
);

CREATE TABLE prices (
                        id SERIAL PRIMARY KEY,
                        category_id INT NOT NULL,
                        amount NUMERIC(10, 2) NOT NULL,
                        CONSTRAINT fk_price_category FOREIGN KEY (category_id) REFERENCES price_categories(id)
);

ALTER TABLE seats ADD COLUMN price_category_id INT;
ALTER TABLE seats ADD CONSTRAINT fk_price_category_seats FOREIGN KEY (price_category_id) REFERENCES price_categories(id);

ALTER TABLE sessions ADD COLUMN price_category_id INT;
ALTER TABLE sessions ADD CONSTRAINT fk_price_category_sessions FOREIGN KEY (price_category_id) REFERENCES price_categories(id);


```
![img.png](..%2Fimages%2Fimg.png)


# Запрос самый прибыльный фильм
```sql
SELECT 
    movies.title,
    SUM(prices.amount) AS total_revenue
FROM 
    tickets
INNER JOIN sessions ON tickets.session_id = sessions.id
INNER JOIN movies ON sessions.movie_id = movies.id
INNER JOIN seats ON tickets.seat_id = seats.id
INNER JOIN price_categories ON seats.price_category_id = price_categories.id
INNER JOIN prices ON price_categories.id = prices.category_id
GROUP BY 
    movies.id, movies.title
ORDER BY 
    total_revenue DESC
LIMIT 1;

```


# Фейк данные
```sql
INSERT INTO price_categories (name, description) VALUES
                                                     ('Standard', 'Standard seating price'),
                                                     ('Premium', 'Higher price for better seats');

INSERT INTO prices (category_id, amount) VALUES
                                             (1, 10.00),
                                             (2, 15.00);


INSERT INTO cinemas (name, address) VALUES
                                        ('Cinema Paradiso', '123 Main St'),
                                        ('The Movie Palace', '456 Grand Ave');

INSERT INTO halls (cinema_id, name, capacity) VALUES
                                                  (1, 'Hall 1', 150),
                                                  (1, 'Hall 2', 200),
                                                  (2, 'Main Hall', 250);

INSERT INTO movies (title, duration, release_date) VALUES
                                                       ('The Grand Journey', 120, '2023-01-01'),
                                                       ('Comedy Nights', 90, '2023-02-01'),
                                                       ('Space Adventure', 130, '2023-03-01');

INSERT INTO sessions (hall_id, movie_id, start_time, price_category_id) VALUES
                                                                            (1, 1, '2023-04-01 14:00:00', 1),
                                                                            (1, 2, '2023-04-01 17:00:00', 1),
                                                                            (2, 3, '2023-04-01 20:00:00', 2);

INSERT INTO seats (hall_id, row_number, seat_number, price_category_id) VALUES
                                                                            (1, 1, 1, 1),
                                                                            (1, 1, 2, 1),
                                                                            (2, 1, 1, 2);


INSERT INTO tickets (session_id, seat_id, price) VALUES
                                                     (1, 1, 10.00),
                                                     (2, 2, 15.00),
                                                     (3, 1, 15.00);
```