INSERT INTO movies (id, name)
VALUES (1, 'Фильм 1'),
       (2, 'Фильм 2');

INSERT INTO movies_attributes_types (id, type)
VALUES (1, 'string'),
       (2, 'integer'),
       (3, 'boolean'),
       (4, 'timestamp'),
       (5, 'text'),
       (6, 'float');


INSERT INTO movies_attributes (id, name, movies_attributes_type_id)
VALUES (1, 'Оскар', 3),
       (2, 'Ника', 3),
       (3, 'Жанр', 1),
       (4, 'Рецензия', 5),
       (5, 'Мировая премьера', 4),
       (6, 'Премьера в РФ', 4),
       (7, 'Дата начала продажи билетов', 4),
       (8, 'Дата запуска рекламы на ТВ', 4);


INSERT INTO movies_attributes_values (movie_id, movies_attributes_id, value_string, value_int, value_timestamp, value_boolean, value_float)
VALUES (1, 1, NULL, NULL, NULL, TRUE, NULL),
       (1, 2, NULL, NULL, NULL, TRUE, NULL),
       (1, 3, 'Комедия', NULL, NULL, NULL, NULL),
       (1, 4, 'Рецензия к фильму 1', NULL, NULL, NULL),
       (1, 5, NULL, NULL, '2024-01-01 10:00:00', NULL, NULL),
       (1, 6, NULL, NULL, '2024-01-21 10:00:00', NULL, NULL),
       (1, 7, NULL, NULL, '2024-01-21 00:00:00', NULL, NULL),
       (1, 8, NULL, NULL, '2024-01-01 00:00:00', NULL, NULL),

       (2, 1, NULL, NULL, NULL, FALSE, NULL),
       (2, 2, NULL, NULL, NULL, FALSE, NULL),
       (2, 3, 'Мультфильм', NULL, NULL, NULL, NULL),
       (2, 4, 'Рецензия к фильму 2', NULL, NULL, NULL,NULL),
       (2, 5, NULL, NULL, '2024-01-01 10:00:00', NULL, NULL),
       (2, 6, NULL, NULL, '2024-01-21 10:00:00', NULL, NULL),
       (2, 7, NULL, NULL, '2024-01-21 00:00:00', NULL, NULL),
       (2, 8, NULL, NULL, '2024-01-01 00:00:00', NULL, NULL);
