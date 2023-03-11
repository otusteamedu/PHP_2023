-- Uuid расширение
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

-- Случайное число
CREATE OR REPLACE FUNCTION random_between(low BIGINT ,high BIGINT)
    RETURNS BIGINT AS
$$ BEGIN
    RETURN floor(random()* (high-low + 1) + low);
END; $$ language 'plpgsql' STRICT;

-- Случайная дата
CREATE OR REPLACE FUNCTION random_timestamp(start_date timestamp, end_date timestamptz)
    RETURNS TIMESTAMP AS
$$ BEGIN
    RETURN start_date + random() * (end_date - start_date);
END; $$ language 'plpgsql' STRICT;

-- 1. Кинотеатры
CREATE TABLE IF NOT EXISTS cinemas
(
    id BIGSERIAL NOT NULL,
    uuid UUID NOT NULL DEFAULT uuid_generate_v4(),
    title VARCHAR(128) NOT NULL,
    description VARCHAR(1024) NOT NULL,
    address VARCHAR(512) NOT NULL,
    thumbnail TEXT NOT NULL,
    halls_count SMALLINT NOT NULL,
    PRIMARY KEY (id)
);

-- 2. Залы
CREATE TABLE IF NOT EXISTS halls
(
    id BIGSERIAL NOT NULL,
    uuid UUID NOT NULL DEFAULT uuid_generate_v4(),
    cinema_id BIGSERIAL NOT NULL,
    title VARCHAR(128) NOT NULL,
    seats_count SMALLINT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (cinema_id) REFERENCES cinemas(id) ON UPDATE CASCADE ON DELETE CASCADE
);

-- 3. Типы мест (ENUM)
DO $$ BEGIN
    IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'seat_type')
        THEN CREATE TYPE seat_type AS ENUM ('basic', 'premium', 'deluxe');
    END IF;
END $$;

-- Места
CREATE TABLE IF NOT EXISTS seats
(
    id BIGSERIAL NOT NULL,
    uuid UUID NOT NULL DEFAULT uuid_generate_v4(),
    hall_id BIGSERIAL NOT NULL,
    row INT NOT NULL,
    number INT NOT NULL,
    type seat_type NOT NULL DEFAULT 'basic',
    PRIMARY KEY (id),
    FOREIGN KEY (hall_id) REFERENCES halls(id) ON UPDATE CASCADE ON DELETE CASCADE,
    UNIQUE (hall_id, row, number)
);

-- 4. Жанры
CREATE TABLE IF NOT EXISTS genres
(
    id BIGSERIAL NOT NULL,
    uuid UUID NOT NULL DEFAULT uuid_generate_v4(),
    title VARCHAR(256) NOT NULL,
    description TEXT NOT NULL,
    PRIMARY KEY (id)
);

-- 5. Фильмы
CREATE TABLE IF NOT EXISTS movies
(
    id BIGSERIAL NOT NULL,
    uuid UUID NOT NULL DEFAULT uuid_generate_v4(),
    genre_id BIGSERIAL NOT NULL,
    title VARCHAR(256) NOT NULL,
    description VARCHAR(1024) NOT NULL,
    duration SMALLINT NOT NULL,
    release_date DATE NOT NULL,
    rental_start TIMESTAMP NOT NULL,
    rental_finish TIMESTAMP NOT NULL,
    rating FLOAT NOT NULL,
    thumbnail TEXT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (genre_id) REFERENCES genres(id) ON UPDATE CASCADE ON DELETE CASCADE
);

-- 6. Сеансы
CREATE TABLE IF NOT EXISTS sessions
(
    id BIGSERIAL NOT NULL,
    uuid UUID NOT NULL DEFAULT uuid_generate_v4(),
    movie_id BIGSERIAL NOT NULL,
    hall_id BIGSERIAL NOT NULL,
    date DATE NOT NULL,
    start_time TIME NOT NULL,
    finish_time TIME NOT NULL,
    price INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (hall_id) REFERENCES halls(id) ON UPDATE CASCADE ON DELETE CASCADE,
    UNIQUE (movie_id, hall_id, date, start_time, finish_time)
);

-- 7. Клиенты
CREATE TABLE IF NOT EXISTS clients
(
    id BIGSERIAL NOT NULL,
    uuid UUID NOT NULL DEFAULT uuid_generate_v4(),
    firstname VARCHAR(256) NOT NULL,
    lastname VARCHAR(256) NOT NULL,
    email VARCHAR(256) NOT NULL,
    phone BIGINT,
    birth_date DATE NOT NULL,
    PRIMARY KEY (id),
    UNIQUE (email),
    UNIQUE (phone)
);

-- 8. Билеты
CREATE TABLE IF NOT EXISTS tickets
(
    id BIGSERIAL NOT NULL,
    uuid UUID NOT NULL DEFAULT uuid_generate_v4(),
    session_id BIGSERIAL NOT NULL,
    seat_id BIGSERIAL NOT NULL,
    client_id BIGSERIAL NOT NULL,
    is_paid BOOLEAN NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (session_id) REFERENCES sessions(id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (seat_id) REFERENCES seats(id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (client_id) REFERENCES clients(id) ON UPDATE CASCADE ON DELETE CASCADE,
    UNIQUE (session_id, seat_id, client_id)
);
