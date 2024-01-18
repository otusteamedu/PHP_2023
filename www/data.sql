INSERT INTO movies (title)
VALUES ('1+1'),
       ('Он — дракон'),
       ('Терминатор'),
       ('Операция Ы'),
       ('Семь');

INSERT INTO types_attributes (type_name)
VALUES ('date'),
       ('text');

INSERT INTO names_attributes (attr_type_id, attr_name)
VALUES (2, 'Рецензия'),
       (2, 'Жанр'),
       (1, 'Важная дата'),
       (1, 'Служебная дата');

INSERT INTO values_attributes (v_movie_id, v_attr_id, value_text, value_date, value_int, value_float, value_bool)
VALUES (1, 1, 'Комедия', NULL, NULL, NULL, NULL),
       (2, 2, 'Фэнтези', NULL, NULL, NULL, NULL),
       (3, 3, NULL, '2024-01-08', NULL, NULL, NULL),
       (4, 4, NULL, '2023-12-19', NULL, NULL, NULL);