/*
* Fill database
*/
CREATE TABLE IF NOT EXISTS users (
    id BIGSERIAL PRIMARY KEY,
    firstname CHAR(255) NOT NULL,
    lastname CHAR(255) NOT NULL,
    email CHAR(255) NOT NULL,
    password CHAR(255) NOT NULL,
    age INT NULL
);

INSERT INTO users (firstname, lastname, email, password, age)
VALUES
    ('Name 1', 'Lastname 1', 'email1@mail.ru', 'password', 18),
    ('Name 2', 'Lastname 2', 'email2@mail.ru', 'password', null),
    ('Name 3', 'Lastname 3', 'email3@mail.ru', 'password', 21),
    ('Name 4', 'Lastname 4', 'email4@mail.ru', 'password', 25),
    ('Name 5', 'Lastname 5', 'email5@mail.ru', 'password', 43);
