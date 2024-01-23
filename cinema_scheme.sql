-- CREATE DATABASE cinema_database;
-- В реальном проекте мы так делать, конечно же, не будем
CREATE USER cinema_user LOGIN PASSWORD 'cinema_password12S34~d~~';

CREATE DATABASE cinema_database OWNER cinema_user;

GRANT ALL PRIVILEGES ON DATABASE cinema_database TO cinema_user;

GRANT ALL ON ALL TABLES IN SCHEMA public TO cinema_user;
GRANT ALL ON ALL SEQUENCES IN SCHEMA public TO cinema_user;

SET search_path TO public;

CREATE EXTENSION btree_gist;

CREATE TABLE IF NOT EXISTS films (
    id bigint PRIMARY KEY GENERATED ALWAYS AS IDENTITY,
    name VARCHAR(255) NOT NULL,
    film_description TEXT,
    duration INTEGER,
    price MONEY,
    age_rating SMALLINT
);

CREATE TABLE IF NOT EXISTS zones (
    id bigint PRIMARY KEY GENERATED ALWAYS AS IDENTITY,
    name VARCHAR(255) NOT NULL,
    coefficient DECIMAL(4,2) DEFAULT 1.00
);

CREATE TABLE IF NOT EXISTS session_types (
    id bigint PRIMARY KEY GENERATED ALWAYS AS IDENTITY,
    name VARCHAR(255) NOT NULL,
    coefficient DECIMAL(4,2) DEFAULT 1.00
);

CREATE TABLE IF NOT EXISTS hall_types (
    id bigint PRIMARY KEY GENERATED ALWAYS AS IDENTITY,
    name VARCHAR(255) NOT NULL,
    coefficient DECIMAL(4,2) DEFAULT 1.00
);

CREATE TABLE IF NOT EXISTS viewers (
    id bigint PRIMARY KEY GENERATED ALWAYS AS IDENTITY,
    full_name VARCHAR(255) NOT NULL,
    age SMALLINT
);

CREATE TABLE IF NOT EXISTS halls (
    id bigint PRIMARY KEY GENERATED ALWAYS AS IDENTITY,
    name VARCHAR(255) NOT NULL,
    coefficient DECIMAL(4,2) DEFAULT 1.00
);

CREATE TABLE IF NOT EXISTS hall_types_halls (
    hall_id INTEGER,
    hall_type_id INTEGER,
    PRIMARY KEY (hall_id, hall_type_id),
    FOREIGN KEY (hall_id) REFERENCES halls (id),
    FOREIGN KEY (hall_type_id) REFERENCES hall_types (id)
);

CREATE TABLE IF NOT EXISTS sessions (
    id bigint PRIMARY KEY GENERATED ALWAYS AS IDENTITY,
    session_type INTEGER,
    hall_id INTEGER,
    film_id INTEGER,
    time_start TIMESTAMP,
    time_end TIMESTAMP,
    FOREIGN KEY (hall_id) REFERENCES halls (id),
    FOREIGN KEY (film_id) REFERENCES films (id),
    FOREIGN KEY (session_type) REFERENCES session_types (id),
    CONSTRAINT session_no_overlap EXCLUDE USING gist (hall_id WITH =, tsrange(time_start, time_end, '[]') WITH &&)
);

CREATE TABLE IF NOT EXISTS seats (
    id bigint PRIMARY KEY GENERATED ALWAYS AS IDENTITY,
    seat_num SMALLINT,
    row_num SMALLINT,
    zone_id INTEGER,
    hall_id INTEGER,
    FOREIGN KEY (zone_id) REFERENCES zones (id),
    FOREIGN KEY (hall_id) REFERENCES halls (id)
);

CREATE TABLE IF NOT EXISTS tickets (
    id bigint PRIMARY KEY GENERATED ALWAYS AS IDENTITY,
    seat_id INTEGER,
    viewer_id INTEGER,
    session_id INTEGER,
    FOREIGN KEY (seat_id) REFERENCES seats (id),
    FOREIGN KEY (viewer_id) REFERENCES viewers (id),
    FOREIGN KEY (session_id) REFERENCES sessions (id)
);

CREATE TABLE IF NOT EXISTS attribute_types (
    id bigint PRIMARY KEY GENERATED ALWAYS AS IDENTITY,
    name TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS attributes (
    id bigint PRIMARY KEY GENERATED ALWAYS AS IDENTITY,
    name TEXT NOT NULL,
    attribute_type_id INTEGER NOT NULL,
    FOREIGN KEY (attribute_type_id) REFERENCES attribute_types (id)
);

CREATE TABLE IF NOT EXISTS attribute_values (
    film_id INTEGER NOT NULL,
    attribute_id INTEGER NOT NULL,
    text_val TEXT,
    bool_val BOOL,
    datetime_val TIMESTAMP,
    numeric_val REAL,
    int_val INTEGER,
    money_val DECIMAL(11,2),
    PRIMARY KEY (film_id, attribute_id),
    FOREIGN KEY (film_id) REFERENCES films (id),
    FOREIGN KEY (attribute_id) REFERENCES attributes (id)
);