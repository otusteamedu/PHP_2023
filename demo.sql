INSERT INTO films (name, release_date, country_production, duration, description) VALUES
     ('Парма', '2022-08-02', 'Россия', 120, 'Описание фильма Парма'),
     ('Жизнь Клима Самгина', '1983-07-03', 'Россия', 129, 'Описание фильма Жизнь Клима Самгина'),
     ('Менты 168', '2020-06-04', 'Россия', 134, 'Описание фильма Менты 168'),
     ('Следствие ведут колобки', '1998-05-06', 'Россия', 115, 'Описание фильма Следствие ведут колобки'),
     ('Замужем за мафией', '1988-09-10', 'Россия', 140, 'Описание фильма Замужем за мафией'),
     ('Тобол', '2018-02-08', 'Россия', 165, 'Описание фильма Тобол');

INSERT INTO attribute_types (name, data_type) VALUES
      ('review', 'text'),
      ('award', 'bool'),
      ('specialDate', 'date'),
      ('serviceDate', 'date');

INSERT INTO attributes (name, attribute_type_id) VALUES
     ('Рецензия журнала "Огонек"', 1),
     ('Рецензия журнала "Мосфильм"', 1),
     ('Отзыв Киноакадемии России', 1),
     ('Премия Оскар', 2),
     ('Премия Ника', 2),
     ('Премия МКФ', 2),
     ('Мировая премьера', 3),
     ('Премьера в Европе', 3),
     ('Премьера в России', 3),
     ('Дата начала продажи билетов', 4),
     ('Дата старта рекламы в интернет-СМИ', 4),
     ('Дата старта рекламы на ТВ', 4);

INSERT INTO film_attribute_values (char_value, integer_value, numeric_value, bool_value, date_value, film_id, attribute_id) VALUES
    ('Текст рецензии журнала Огонек к фильму Парма', NULL, NULL, NULL, NULL, 1, 1),
    ('Текст рецензии журнала Мосфильм к фильму Парма', NULL, NULL, NULL, NULL, 4, 2),
    ('Текст отзыва Киноакадемии России к фильму Парма', NULL, NULL, NULL, NULL, 4, 3),
    (NULL, NULL, NULL, FALSE, NULL, 1, 4),
    (NULL, NULL, NULL, TRUE, NULL, 1, 5),
    (NULL, NULL, NULL, TRUE, NULL, 1, 6),
    (NULL, NULL, NULL, NULL, '2023-04-01', 1, 7),
    (NULL, NULL, NULL, NULL, '2023-04-02', 1, 8),
    (NULL, NULL, NULL, NULL, '2023-04-03', 1, 9),
    (NULL, NULL, NULL, NULL, '2023-03-30', 1, 10),
    (NULL, NULL, NULL, NULL, '2023-03-27', 1, 11),
    (NULL, NULL, NULL, NULL, '2023-03-18', 1, 12),

    ('Текст рецензии журнала Огонек к фильму Жизнь Клима Самгина', NULL, NULL, NULL, NULL, 2, 1),
    ('Текст рецензии журнала Мосфильм к фильму Жизнь Клима Самгина', NULL, NULL, NULL, NULL, 2, 2),
    ('Текст отзыва Киноакадемии России к фильму Жизнь Клима Самгина', NULL, NULL, NULL, NULL, 2, 3),
    (NULL, NULL, NULL, TRUE, NULL, 2, 4),
    (NULL, NULL, NULL, FALSE, NULL, 2, 5),
    (NULL, NULL, NULL, TRUE, NULL, 2, 6),
    (NULL, NULL, NULL, NULL, '2023-05-02', 2, 7),
    (NULL, NULL, NULL, NULL, '2023-05-03', 2, 8),
    (NULL, NULL, NULL, NULL, '2023-05-04', 2, 9),
    (NULL, NULL, NULL, NULL, '2023-03-18', 2, 10),
    (NULL, NULL, NULL, NULL, '2023-04-07', 2, 11),
    (NULL, NULL, NULL, NULL, '2023-04-07', 2, 12),

    ('Текст рецензии журнала Огонек к фильму Менты 168', NULL, NULL, NULL, NULL, 3, 1),
    ('Текст рецензии журнала Мосфильм к фильму Менты 168', NULL, NULL, NULL, NULL, 3, 2),
    ('Текст отзыва Киноакадемии России к фильму Менты 168', NULL, NULL, NULL, NULL, 3, 3),
    (NULL, NULL, NULL, FALSE, NULL, 3, 4),
    (NULL, NULL, NULL, FALSE, NULL, 3, 5),
    (NULL, NULL, NULL, TRUE, NULL, 3, 6),
    (NULL, NULL, NULL, NULL, '2023-04-08', 3, 7),
    (NULL, NULL, NULL, NULL, '2023-04-09', 3, 8),
    (NULL, NULL, NULL, NULL, '2023-04-10', 3, 9),
    (NULL, NULL, NULL, NULL, '2023-03-18', 3, 10),
    (NULL, NULL, NULL, NULL, '2023-04-07', 3, 11),
    (NULL, NULL, NULL, NULL, '2023-03-18', 3, 12),

    ('Текст рецензии журнала Огонек к фильму Следствие ведут колобки', NULL, NULL, NULL, NULL, 4, 1),
    ('Текст рецензии журнала Мосфильм к фильму Следствие ведут колобки', NULL, NULL, NULL, NULL, 4, 2),
    ('Текст отзыва Киноакадемии России к фильму Следствие ведут колобки', NULL, NULL, NULL, NULL, 4, 3),
    (NULL, NULL, NULL, TRUE, NULL, 4, 4),
    (NULL, NULL, NULL, TRUE, NULL, 4, 5),
    (NULL, NULL, NULL, TRUE, NULL, 4, 6),
    (NULL, NULL, NULL, NULL, '2023-04-09', 4, 7),
    (NULL, NULL, NULL, NULL, '2023-04-10', 4, 8),
    (NULL, NULL, NULL, NULL, '2023-04-11', 4, 9),
    (NULL, NULL, NULL, NULL, '2023-03-18', 4, 10),
    (NULL, NULL, NULL, NULL, '2023-04-07', 4, 11),
    (NULL, NULL, NULL, NULL, '2023-03-18', 4, 12),

    ('Текст рецензии журнала Огонек к фильму Замужем за мафией', NULL, NULL, NULL, NULL, 5, 1),
    ('Текст рецензии журнала Мосфильм к фильму Замужем за мафией', NULL, NULL, NULL, NULL, 5, 2),
    ('Текст отзыва Киноакадемии России к фильму Замужем за мафией', NULL, NULL, NULL, NULL, 5, 3),
    (NULL, NULL, NULL, TRUE, NULL, 5, 4),
    (NULL, NULL, NULL, TRUE, NULL, 5, 5),
    (NULL, NULL, NULL, TRUE, NULL, 5, 6),
    (NULL, NULL, NULL, NULL, '2023-06-10', 5, 7),
    (NULL, NULL, NULL, NULL, '2023-06-11', 5, 8),
    (NULL, NULL, NULL, NULL, '2023-06-12', 5, 9),
    (NULL, NULL, NULL, NULL, '2023-03-18', 5, 10),
    (NULL, NULL, NULL, NULL, '2023-03-18', 5, 11),
    (NULL, NULL, NULL, NULL, '2023-04-07', 5, 12),

    ('Текст рецензии журнала Огонек к фильму Тобол', NULL, NULL, NULL, NULL, 6, 1),
    ('Текст рецензии журнала Мосфильм к фильму Тобол', NULL, NULL, NULL, NULL, 6, 2),
    ('Текст отзыва Киноакадемии России к фильму Тобол', NULL, NULL, NULL, NULL, 6, 3),
    (NULL, NULL, NULL, FALSE, NULL, 6, 4),
    (NULL, NULL, NULL, TRUE, NULL, 6, 5),
    (NULL, NULL, NULL, FALSE, NULL, 6, 6),
    (NULL, NULL, NULL, NULL, '2023-07-11', 6, 7),
    (NULL, NULL, NULL, NULL, '2023-07-12', 6, 8),
    (NULL, NULL, NULL, NULL, '2023-07-13', 6, 9),
    (NULL, NULL, NULL, NULL, '2023-04-07', 6, 10),
    (NULL, NULL, NULL, NULL, '2023-03-18', 6, 11),
    (NULL, NULL, NULL, NULL, '2023-04-07', 6, 12);

INSERT INTO prices (amount) VALUES (200), (250), (300), (350), (400), (450);

-- Генерация сущностей до 10 000 записей
INSERT INTO customers (user_name, email) SELECT 'user' || generate_series(1,100), random_string(6) || '@test.ru';
INSERT INTO halls (number, capacity) VALUES (1, 300);

-- Генерация сущностей до 10 000 000 записей
INSERT INTO customers (user_name, email) SELECT 'user' || generate_series(2,1000), random_string(6) || '@test.ru';
INSERT INTO halls (number, capacity) SELECT generate_series(2,105), 300;
