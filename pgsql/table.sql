CREATE TABLE Movies
(
    movie_id     INT PRIMARY KEY,
    title        VARCHAR(255),
    description  TEXT,
    release_date DATE
);

CREATE TABLE Attributes
(
    attribute_id INT PRIMARY KEY,
    name         VARCHAR(255),
    type_id      INT,
    FOREIGN KEY (type_id) REFERENCES AttributeTypes (type_id)
);

CREATE TABLE Values
(
    value_id     INT PRIMARY KEY,
    movie_id     INT,
    attribute_id INT,
    value        TEXT,
    FOREIGN KEY (movie_id) REFERENCES Movies (movie_id),
    FOREIGN KEY (attribute_id) REFERENCES Attributes (attribute_id)
);

CREATE TABLE AttributeTypes
(
    type_id   INT PRIMARY KEY,
    type_name VARCHAR(50)
);

CREATE INDEX idx_movie_id ON Values (movie_id);
CREATE INDEX idx_attribute_id ON Values (attribute_id);