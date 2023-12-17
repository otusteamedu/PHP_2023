INSERT INTO movies (name, duration)
VALUES ('Джентльмены', 113),
       ('Волк с Уолл-стрит', 180),
       ('Один дома', 103);

INSERT INTO attribute_types (name)
VALUES ('Рецензии'),
       ('Премия'),
       ('Важные даты'),
       ('Служебные даты');

INSERT INTO attributes (name, type_id)
VALUES ('Рецензии критиков', 1),
       ('Отзыв неизвестной киноакадемии', 1),
       ('Оскар', 2),
       ('Ника', 2),
       ('Мировая премьера', 3),
       ('Премьера в РФ', 3),
       ('Дата начала продажи билетов', 4),
       ('Когда запускать рекламу на ТВ', 4);

INSERT INTO attribute_values (movie_id, attribute_id, val_text, val_bool, val_int, val_date)
VALUES (1, 1, 'Рецензия 1', null, null, null),
       (2, 2, 'Отзыв 1', null, null, null),
       (3, 2, 'Отзыв 2', null, null, null),
       (1, 3, null, true, null, null),
       (2, 3, null, true, null, null),
       (3, 4, null, true, null, null),
       (1, 5, null, null, null, '2024-01-01'),
       (2, 5, null, null, null, '2024-01-02'),
       (3, 6, null, null, null, '2023-12-31'),
       (1, 7, null, null, null, '2024-01-01'),
       (2, 8, null, null, null, '2024-01-02'),
       (3, 8, null, null, null, '2023-12-31');
