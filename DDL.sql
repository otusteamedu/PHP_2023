CREATE TABLE cinemas
(
    id INT PRIMARY KEY,
    name VARCHAR(255)
);

CREATE TABLE transaction_statuses
(
    id INT PRIMARY KEY,
    name VARCHAR(255)
);

CREATE TABLE sources
(
    id INT PRIMARY KEY,
    name VARCHAR(255)
);

CREATE TABLE sessions
(
    id INT PRIMARY KEY,
    name VARCHAR(255),
    durability INT
);

CREATE TABLE halls
(
    id INT PRIMARY KEY,
    number INT,
    cinema_id INT,
    capacity INT,
    FOREIGN KEY (cinema_id) REFERENCES cinemas (id)
);

CREATE TABLE hall_sessions
(
    id INT PRIMARY KEY,
    created_at DATE,
    session_time_end_at DATE,
    session_time_start_at DATE,
    hall_id INT,
    session_id INT,
    fullness INT,
    FOREIGN KEY (hall_id) REFERENCES halls (id),
    FOREIGN KEY (session_id) REFERENCES sessions (id)
);

CREATE TABLE places
(
    id INT PRIMARY KEY,
    hall_session_id INT,
    raw INT,
    seat INT,
    is_busy BOOL,
    FOREIGN KEY (hall_session_id) REFERENCES hall_sessions (id)
);


CREATE TABLE transactions
(
    id INT PRIMARY KEY,
    created_at DATE,
    value FLOAT,
    source_id INT,
    place_id INT,
    discount FLOAT,
    amount FLOAT,
    transaction_status_id INT,
    FOREIGN KEY (source_id) REFERENCES sources (id),
    FOREIGN KEY (place_id) REFERENCES places (id),
    FOREIGN KEY (transaction_status_id) REFERENCES transaction_statuses (id)
);
