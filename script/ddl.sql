ddl

-- broadcasting definition

CREATE TABLE broadcasting (
    id INTEGER NOT NULL,
    movie_id INTEGER NOT NULL,
    screening_id INTEGER NOT NULL
);


-- client definition

CREATE TABLE client (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT
);

-- hall definition

CREATE TABLE hall (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT,
    screening_id INTEGER
);

-- movie definition

CREATE TABLE movie (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT
);

-- screening definition

CREATE TABLE screening (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT
);

-- seat definition

CREATE TABLE seat (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT
);

-- ticket definition

CREATE TABLE ticket (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT,
    screening_id INTEGER,
    price REAL,
    client_id INTEGER,
    seat_id INTEGER,
    date TEXT,
    date_number INTEGER
, hall_id INTEGER DEFAULT (1));

