INSERT INTO movie (name, director, genre, duration)
VALUES ('Человек паук: паутина вселенных', 'Жуакин Душ Сантуш', 'Мультфильм', 140),
       ('Всё везде и сразу', 'Дэн Кван', 'Фантастика', 139),
       ('RRR: Рядом ревёт революция', 'С.С. Раджамули', 'Боевик', 187);

INSERT INTO attribute_type (name)
VALUES ('text'),
       ('boolean'),
       ('date');

INSERT INTO attribute (name, type_id)
VALUES ('Рецензии', 1),
       ('Премии', 2),
       ('Мировая премьера', 3),
       ('Старт продаж билетов', 3),
       ('Запуск рекламы', 3);

INSERT INTO value (movie_id, attribute_id, text_value, boolean_value, date_value)
VALUES (1, 1, 'Новая веха в мультипликации, безоговорочный номинант на оскар', NULL, NULL),
       (1, 2, NULL, TRUE, NULL),
       (1, 3, NULL, NULL, '2023-06-30'),
       (1, 4, NULL, NULL, '2023-06-30'),
       (2, 1, '7 статуэток, лучший фильм 2022', NULL, NULL),
       (2, 3, NULL, NULL, '2023-06-27'),
       (2, 4, NULL, NULL, '2023-06-27'),
       (2, 5, NULL, NULL, '2023-05-27');
