
-- "_demostration" definition

CREATE TABLE "_demostration" (
    id INTEGER NOT NULL,
    hall_id INTEGER NOT NULL,
    session_id INTEGER NOT NULL,
    film_id INTEGER NOT NULL,
    attendance_rate INTEGER
);


-- "_film" definition

CREATE TABLE "_film" (
    id INTEGER NOT NULL,
    name TEXT NOT NULL,
    duration_in_minutes INTEGER
);

-- "_hall" definition

CREATE TABLE "_hall" (
    id INTEGER NOT NULL,
    name TEXT NOT NULL,
    seating_capacity INTEGER NOT NULL
);

-- "_location" definition

CREATE TABLE "_location" (
    id INTEGER NOT NULL,
    name TEXT,
    floor INTEGER DEFAULT (1) NOT NULL,
    "row" INTEGER NOT NULL,
    number_in_row INTEGER NOT NULL
);

-- "_seating_position" definition

CREATE TABLE "_seating_position" (
    id INTEGER NOT NULL,
    name TEXT,
    hall_id INTEGER NOT NULL,
    seat_id INTEGER NOT NULL,
    attendance_rate INTEGER,
    location_id INTEGER
);

-- "_session" definition

CREATE TABLE "_session" (
    id INTEGER NOT NULL,
    "text" TEXT NOT NULL
);

-- "_status" definition

CREATE TABLE "_status" (
    id INTEGER NOT NULL,
    name TEXT NOT NULL
);

-- "_ticket" definition

CREATE TABLE "_ticket" (
    id INTEGER NOT NULL,
    demonstation_id INTEGER NOT NULL,
    status_id INTEGER NOT NULL,
    price INTEGER NOT NULL,
    "position_id" INTEGER
);

-- "_seat" definition

CREATE TABLE "_seat" (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT
);

-- "_ui_color" definition

CREATE TABLE "_ui_color" (
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL
);
