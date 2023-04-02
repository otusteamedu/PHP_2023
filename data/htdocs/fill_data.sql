/**********************************************************************************/
/*                                  TABLES                                        */
/**********************************************************************************/
INSERT INTO halls("id", "name")
VALUES (1, 'Красный зал'),
       (2, 'Желтый зал'),
       (3, 'Желтый зал'),
       (4, 'Зеленый зал');

INSERT INTO seats("hall_id", "row_number", "place_number")
VALUES
    (1, 1, 1),
    (1, 1, 2),
    (1, 1, 3),
    (1, 1, 4),
    (1, 2, 1),
    (1, 2, 2),
    (1, 2, 3),
    (1, 2, 4),
    (1, 3, 1),
    (1, 3, 2),
    (1, 3, 3),
    (1, 3, 4),
    (1, 4, 1),
    (1, 4, 2),
    (1, 4, 3),
    (1, 4, 4),

    (2, 1, 1),
    (2, 1, 2),
    (2, 1, 3),
    (2, 1, 4),
    (2, 2, 1),
    (2, 2, 2),
    (2, 2, 3),
    (2, 2, 4),
    (2, 3, 1),
    (2, 3, 2),
    (2, 3, 3),
    (2, 3, 4),
    (2, 4, 1),
    (2, 4, 2),
    (2, 4, 3),
    (2, 4, 4),

    (3, 1, 1),
    (3, 1, 2),
    (3, 1, 3),
    (3, 1, 4),
    (3, 2, 1),
    (3, 2, 2),
    (3, 2, 3),
    (3, 2, 4),
    (3, 3, 1),
    (3, 3, 2),
    (3, 3, 3),
    (3, 3, 4),
    (3, 4, 1),
    (3, 4, 2),
    (3, 4, 3),
    (3, 4, 4),

    (4, 1, 1),
    (4, 1, 2),
    (4, 1, 3),
    (4, 1, 4),
    (4, 2, 1),
    (4, 2, 2),
    (4, 2, 3),
    (4, 2, 4),
    (4, 3, 1),
    (4, 3, 2),
    (4, 3, 3),
    (4, 3, 4),
    (4, 4, 1),
    (4, 4, 2),
    (4, 4, 3),
    (4, 4, 4);

INSERT INTO genres(id, name) VALUES (1, 'Драма');
INSERT INTO genres(id, name) VALUES (2, 'Криминал');
INSERT INTO genres(id, name) VALUES (3, 'Ужас');
INSERT INTO genres(id, name) VALUES (4, 'Триллер');

INSERT INTO
    films(id, name, description, kp_rating, duration, release_date, cover_id)
    (
        SELECT
            gs.id as id,
            'film_' || random_string(16) as name,
            null as description,
            random_between(0, 10) as kp,
            round(random_between(60, 240)) as duration,
            random_date_between('1990-01-01'::DATE, '2023-01-01'::DATE) as release_date,
            null as cover
        FROM generate_series(1,100) as gs(id)
    );

INSERT INTO films_genres(id, film_id, genre_id)
    SELECT
       gs.id,
       random_between((SELECT MIN(id) FROM films), (SELECT MAX(id) FROM films)),
       random_between((SELECT MIN(id) FROM genres), (SELECT MAX(id) FROM genres))
    FROM generate_series(1,300) as gs(id);


INSERT INTO users(id, name, last_name, password, email, avatar) (SELECT gs.id, random_string(16), random_string(16), random_string(16), random_string(16) || '@' || random_string(16) || '.com', null FROM generate_series(1,1000) as gs(id));

/**********************************************************************************/
/*                                  Discounts                                     */
/**********************************************************************************/
INSERT INTO discounts_types(id, name) VALUES (1, 'fix_price');
INSERT INTO discounts_types(id, name) VALUES (2, 'percent');

INSERT INTO discounts(id, name, discount_type_id,  value) VALUES (1, 'Детские билеты', 1, 1000);
INSERT INTO discounts(id, name, discount_type_id, value) VALUES (2, 'Студенческие билеты', 2, 50);

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
