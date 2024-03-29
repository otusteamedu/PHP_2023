INSERT INTO "movie"
    (name) VALUES
               ('Робокоп'),
               ('Терминатор');

INSERT INTO "attribute"
(name, type_id) VALUES
           ('Описание', 7),
           ('Продолжительность', 8),
           ('Рецензии критиков', 1),
           ('Рецензия киноакадемии', 1),
           ('Отзыв зрителя', 2),
           ('Премия Оскар', 3),
           ('Премия Ника', 3),
           ('Премия Золотой глобус', 3),
           ('Кассовые сборы: Россия', 4),
           ('Кассовые сборы: Мир', 4),
           ('Дата начала продажи билетов', 5),
           ('Дата запуска рекламной компании', 5),
           ('Премьера в России', 6),
           ('Премьера в Мире', 6);

INSERT INTO "attribute_type"
(name, type) VALUES
           ('рецензия текстовое значение', 'text'),
           ('отзыв текстовое значение', 'text'),
           ('премия логическое значение', 'boolean'),
           ('сумма денег', 'float'),
           ('служебная дата', 'date'),
           ('важная дата', 'date'),
           ('описание текстовое значение', 'text'),
           ('продолжительность (мин)', 'integer');

INSERT INTO "movie_data"
(movie_id, attribute_id, value_text, value_float, value_integer, value_boolean, value_date)
VALUES
    (1, 1, 'Описание робокопа', null, null, null, null),
    (1, 2, null, null, 90, null, null),
    (1, 3, 'Критики оценили фильм положительно', null, null, null, null),
    (1, 4, 'Критики киноакадемии оценили фильм положительно', null, null, null, null),
    (1, 5, 'Зрители оценили фильм положительно', null, null, null, null),
    (1, 6, null, null, null, true, null),
    (1, 7, null, null, null, true, null),
    (1, 8, null, null, null, true, null),
    (1, 9, null, 2045600, null, null, null),
    (1, 10, null, 400321000, null, null, null),
    (1, 11, null, null, null, null, (CURRENT_DATE + INTERVAL '20 DAY')::TIMESTAMP WITHOUT TIME ZONE),
    (1, 12, null, null, null, null, CURRENT_DATE::TIMESTAMP WITHOUT TIME ZONE),
    (1, 13, null, null, null, null, '2024-04-25'),
    (1, 14, null, null, null, null, '2024-04-25');

INSERT INTO "movie_data"
(movie_id, attribute_id, value_text, value_float, value_integer, value_boolean, value_date)
VALUES
    (2, 1, 'Описание терминатора', null, null, null, null),
    (2, 2, null, null, 104, null, null),
    (2, 3, 'Критики оценили фильм отрицательно', null, null, null, null),
    (2, 4, 'Критики киноакадемии оценили фильм отрицательно', null, null, null, null),
    (2, 5, 'Зрители оценили фильм положительно', null, null, null, null),
    (2, 6, null, null, null, false, null),
    (2, 7, null, null, null, false, null),
    (2, 8, null, null, null, false, null),
    (2, 9, null, 37120000, null, null, null),
    (2, 10, null, 50000000, null, null, null),
    (2, 11, null, null, null, null, '2024-04-02'),
    (2, 12, null, null, null, null, '2024-04-15'),
    (2, 13, null, null, null, null, '2024-04-27'),
    (2, 14, null, null, null, null, '2024-04-27');