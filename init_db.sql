
INSERT INTO movies (movie_name)
VALUES ('Побег из Шоушенка'),
       ('Зеленая миля'),
       ('21'),
       ('Обитель зла');

INSERT INTO attributes_type (attr_type_name)
VALUES ('date'),
       ('text'),
       ('int');

INSERT INTO attributes_names (attr_type_id, attr_name)
VALUES (2, 'Рецензия'),
       (2, 'Жанр'),
       (1, 'Начало рекламной кампании'),
       (1, 'Начало показа'),
       (3, 'Возрастное ограничение');

INSERT INTO attributes_values (attr_val_movie_id, attr_type_id, attr_value_str, attr_value_int, attr_value_bool, attr_value_date, attr_value_float)
VALUES (1, 2, 'Приключения', NULL, NULL, NULL, NULL),
       (2, 2, 'Драмма', NULL, NULL, NULL, NULL), 
       (3, 3, NULL, NULL, NULL, CURRENT_DATE, NULL),
       (4, 4, NULL, NULL, NULL, CURRENT_DATE + INTERVAL '20 days', NULL),
       (4, 5, NULL, 18, NULL, NULL, NULL);

      