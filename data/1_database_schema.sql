CREATE TABLE IF NOT EXISTS film (
    id          BIGSERIAL NOT NULL PRIMARY KEY,
    name        varchar(255) NOT NULL,
    description varchar(255)
);
