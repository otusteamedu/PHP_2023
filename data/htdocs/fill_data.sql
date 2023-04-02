INSERT INTO genres(id, name) VALUES (1, 'Драма');
INSERT INTO genres(id, name) VALUES (2, 'Криминал');
INSERT INTO genres(id, name) VALUES (3, 'Ужас');
INSERT INTO genres(id, name) VALUES (4, 'Триллер');

INSERT INTO films(id, name, description, kp_rating, duration, release_date, cover_id) VALUES (1, 'Славные парни', null, 7.5, 120, '2000-01-01', null);
INSERT INTO films(id, name, description, kp_rating, duration, release_date, cover_id) VALUES (2, 'Ганибал', null, 7.5, 100, '2002-01-01', null);
INSERT INTO films(id, name, description, kp_rating, duration, release_date, cover_id) VALUES (3, 'Чужие', null, 8, 130, '1998-01-01', null);

INSERT INTO films_genres(film_id, genre_id) VALUES (1, 1);
INSERT INTO films_genres(film_id, genre_id) VALUES (1, 2);
INSERT INTO films_genres(film_id, genre_id) VALUES (2, 3);
INSERT INTO films_genres(film_id, genre_id) VALUES (2, 4);
INSERT INTO films_genres(film_id, genre_id) VALUES (3, 2);

/**********************************************************************************/
/*                                  Attributes                                    */
/**********************************************************************************/
INSERT INTO attributes_types (id, name, field_name) VALUES (1, 'Текст/html', 'text');
INSERT INTO attributes_types (id, name, field_name) VALUES (2, 'Целое число', 'int');
INSERT INTO attributes_types (id, name, field_name) VALUES (3, 'Дробное число', 'double');
INSERT INTO attributes_types (id, name, field_name) VALUES (4, 'Дата', 'date');
INSERT INTO attributes_types (id, name, field_name) VALUES (5, 'Да/Нет', 'bool');

-- text
INSERT INTO attributes_groups (id, name) VALUES (1, 'Рецензии');
INSERT INTO attributes (id, name, type_id, multiple, group_id) VALUES (1, 'Рецензии критиков', 1, true, 1);
INSERT INTO attributes_values (film_id, attribute_id, text) VALUES (1, 1, 'Рецензия #1');
INSERT INTO attributes_values (film_id, attribute_id, text) VALUES (1, 1, 'Рецензия #2');
INSERT INTO attributes_values (film_id, attribute_id, text) VALUES (1, 1, 'Рецензия #3');

INSERT INTO attributes_groups (id, name) VALUES (7, 'Отзывы');
INSERT INTO attributes (id, name, type_id, multiple, group_id) VALUES (8, 'Отзыв неизвестной киноакадемии', 1, true, 7);
INSERT INTO attributes_values (film_id, attribute_id, text) VALUES (1, 8, 'Отзыв №1');

-- bool
INSERT INTO attributes_groups (id, name) VALUES (2, 'Премии');
INSERT INTO attributes (id, name, type_id, multiple, group_id) VALUES (2, 'Оскар', 5, false, 2);
INSERT INTO attributes (id, name, type_id, multiple, group_id) VALUES (3, 'Ника ', 5, false, 2);
INSERT INTO attributes_values (film_id, attribute_id, bool) VALUES (1, 2, true);
INSERT INTO attributes_values (film_id, attribute_id, bool) VALUES (1, 2, false);

-- date
INSERT INTO attributes_groups (id, name) VALUES (3, 'Важные даты');
INSERT INTO attributes (id, name, type_id, multiple, group_id) VALUES (4, 'Дата премьеры РФ', 4, false, 3);
INSERT INTO attributes (id, name, type_id, multiple, group_id) VALUES (5, 'Дата премьеры МИР', 4, false, 3);
INSERT INTO attributes_values (film_id, attribute_id, date) VALUES (1, 4, '2022-02-02');
INSERT INTO attributes_values (film_id, attribute_id, date) VALUES (1, 5, '2022-02-02');

INSERT INTO attributes_groups (id, name) VALUES (4, 'Служебные даты');
INSERT INTO attributes (id, name, type_id, multiple, group_id) VALUES (6, 'Дата начала продаж билетов', 4, false, 4);
INSERT INTO attributes (id, name, type_id, multiple, group_id) VALUES (7, 'Дата запуска рекламы', 4, false, 4);
INSERT INTO attributes_values (film_id, attribute_id, date) VALUES (1, 6, current_date);
INSERT INTO attributes_values (film_id, attribute_id, date) VALUES (1, 7, current_date + 20);

INSERT INTO attributes_groups (id, name) VALUES (5, 'Задачи');
INSERT INTO attributes_groups (id, name) VALUES (6, 'Маркетинг');
