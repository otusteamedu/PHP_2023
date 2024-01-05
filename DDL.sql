-- Таблица фильмов
CREATE TABLE Movies
(
    MovieID     INT PRIMARY KEY,
    Title       VARCHAR(255),
    ReleaseDate DATE
);

-- Таблица атрибутов
CREATE TABLE Attributes
(
    AttributeID     INT PRIMARY KEY,
    AttributeName   VARCHAR(255),
    AttributeTypeID INT,
    FOREIGN KEY (AttributeTypeID) REFERENCES AttributeTypes (AttributeTypeID)
);

-- Таблица типов атрибутов
CREATE TABLE AttributeTypes
(
    AttributeTypeID INT PRIMARY KEY,
    TypeName        VARCHAR(50)
);

-- Таблица значений атрибутов
CREATE TABLE AttributeValues
(
    MovieID      INT,
    AttributeID  INT,
    ValueText    VARCHAR(255),
    ValueDate    DATE,
    ValueBoolean BIT,
    ValueFloat   FLOAT,
    PRIMARY KEY (MovieID, AttributeID),
    FOREIGN KEY (MovieID) REFERENCES Movies (MovieID),
    FOREIGN KEY (AttributeID) REFERENCES Attributes (AttributeID)
);

-- Индексы для оптимизации запросов
CREATE INDEX idx_MovieID ON AttributeValues (MovieID);
CREATE INDEX idx_AttributeID ON AttributeValues (AttributeID);
CREATE INDEX idx_TypeName ON AttributeTypes (TypeName);

CREATE VIEW CurrentAndFutureTasks AS
SELECT M.Title      AS MovieTitle,
       AV.ValueText AS Task,
       AV.ValueDate AS TaskDate
FROM Movies M
         JOIN
     AttributeValues AV ON M.MovieID = AV.MovieID
         JOIN
     Attributes A ON AV.AttributeID = A.AttributeID
         JOIN
     AttributeTypes AT ON A.AttributeTypeID = AT.AttributeTypeID
WHERE
    AT.TypeName = 'Date'
    AND AV.ValueDate >= GETDATE()
    AND AV.ValueDate <= DATEADD(DAY, 20, GETDATE());


CREATE VIEW MarketingData AS
SELECT M.Title         AS MovieTitle,
       AT.TypeName     AS AttributeType,
       A.AttributeName AS Attribute,
       AV.ValueText    AS AttributeValue,
       AV.ValueDate    AS ValueDate,
       AV.ValueBoolean AS ValueBoolean,
       AV.ValueFloat   AS ValueFloat,
FROM Movies M
         JOIN
     AttributeValues AV ON M.MovieID = AV.MovieID
         JOIN
     Attributes A ON AV.AttributeID = A.AttributeID
         JOIN
     AttributeTypes AT ON A.AttributeTypeID = AT.AttributeTypeID;
