INSERT INTO movies (title)
VALUES ('Командо'),
       ('Властелин колец: Возвращение короля'),
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

INSERT INTO values_attributes (v_movie_id, v_attr_id, value)
VALUES (1, 1, 'Классический боевик Арни'),
       (2, 2, 'Фэнтези'),
       (3, 3, '2024-01-07'),
       (4, 4, '2023-12-18');