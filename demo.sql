
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


INSERT INTO film_attribute_values (text_value, char_value, integer_value, float_value, numeric_value, bool_value, date_value, film_id, attribute_id) VALUES
     ('Текст рецензии журнала Огонек к фильму Парма', NULL, NULL, NULL, NULL, NULL, NULL, 4, 1),
     ('Текст рецензии журнала Мосфильм к фильму Парма', NULL, NULL, NULL, NULL, NULL, NULL, 4, 2),
     ('Текст отзыва Киноакадемии России к фильму Парма', NULL, NULL, NULL, NULL, NULL, NULL, 4, 3),
     (NULL, NULL, NULL, NULL, NULL, FALSE, NULL, 4, 4),
     (NULL, NULL, NULL, NULL, NULL, TRUE, NULL, 4, 5),
     (NULL, NULL, NULL, NULL, NULL, TRUE, NULL, 4, 6),
     (NULL, NULL, NULL, NULL, NULL, NULL, '2023-04-01', 4, 7),
     (NULL, NULL, NULL, NULL, NULL, NULL, '2023-04-02', 4, 8),
     (NULL, NULL, NULL, NULL, NULL, NULL, '2023-04-03', 4, 9),
     (NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-30', 4, 10),
     (NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-27', 4, 11),
     (NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-17', 4, 12),

     ('Текст рецензии журнала Огонек к фильму Жизнь Клима Самгина', NULL, NULL, NULL, NULL, NULL, NULL, 5, 1),
     ('Текст рецензии журнала Мосфильм к фильму Жизнь Клима Самгина', NULL, NULL, NULL, NULL, NULL, NULL, 5, 2),
     ('Текст отзыва Киноакадемии России к фильму Жизнь Клима Самгина', NULL, NULL, NULL, NULL, NULL, NULL, 5, 3),
     (NULL, NULL, NULL, NULL, NULL, TRUE, NULL, 5, 4),
     (NULL, NULL, NULL, NULL, NULL, FALSE, NULL, 5, 5),
     (NULL, NULL, NULL, NULL, NULL, TRUE, NULL, 5, 6),
     (NULL, NULL, NULL, NULL, NULL, NULL, '2023-05-02', 5, 7),
     (NULL, NULL, NULL, NULL, NULL, NULL, '2023-05-03', 5, 8),
     (NULL, NULL, NULL, NULL, NULL, NULL, '2023-05-04', 5, 9),
     (NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-17', 5, 10),
     (NULL, NULL, NULL, NULL, NULL, NULL, '2023-04-07', 5, 11),
     (NULL, NULL, NULL, NULL, NULL, NULL, '2023-04-07', 5, 12),

     ('Текст рецензии журнала Огонек к фильму Менты 168', NULL, NULL, NULL, NULL, NULL, NULL, 6, 1),
     ('Текст рецензии журнала Мосфильм к фильму Менты 168', NULL, NULL, NULL, NULL, NULL, NULL, 6, 2),
     ('Текст отзыва Киноакадемии России к фильму Менты 168', NULL, NULL, NULL, NULL, NULL, NULL, 6, 3),
     (NULL, NULL, NULL, NULL, NULL, FALSE, NULL, 6, 4),
     (NULL, NULL, NULL, NULL, NULL, FALSE, NULL, 6, 5),
     (NULL, NULL, NULL, NULL, NULL, TRUE, NULL, 6, 6),
     (NULL, NULL, NULL, NULL, NULL, NULL, '2023-04-08', 6, 7),
     (NULL, NULL, NULL, NULL, NULL, NULL, '2023-04-09', 6, 8),
     (NULL, NULL, NULL, NULL, NULL, NULL, '2023-04-10', 6, 9),
     (NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-17', 6, 10),
     (NULL, NULL, NULL, NULL, NULL, NULL, '2023-04-07', 6, 11),
     (NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-18', 6, 12),

     ('Текст рецензии журнала Огонек к фильму Следствие ведут колобки', NULL, NULL, NULL, NULL, NULL, NULL, 7, 1),
     ('Текст рецензии журнала Мосфильм к фильму Следствие ведут колобки', NULL, NULL, NULL, NULL, NULL, NULL, 7, 2),
     ('Текст отзыва Киноакадемии России к фильму Следствие ведут колобки', NULL, NULL, NULL, NULL, NULL, NULL, 7, 3),
     (NULL, NULL, NULL, NULL, NULL, TRUE, NULL, 7, 4),
     (NULL, NULL, NULL, NULL, NULL, TRUE, NULL, 7, 5),
     (NULL, NULL, NULL, NULL, NULL, TRUE, NULL, 7, 6),
     (NULL, NULL, NULL, NULL, NULL, NULL, '2023-04-09', 7, 7),
     (NULL, NULL, NULL, NULL, NULL, NULL, '2023-04-10', 7, 8),
     (NULL, NULL, NULL, NULL, NULL, NULL, '2023-04-11', 7, 9),
     (NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-18', 7, 10),
     (NULL, NULL, NULL, NULL, NULL, NULL, '2023-04-07', 7, 11),
     (NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-18', 7, 12),

     ('Текст рецензии журнала Огонек к фильму Замужем за мафией', NULL, NULL, NULL, NULL, NULL, NULL, 8, 1),
     ('Текст рецензии журнала Мосфильм к фильму Замужем за мафией', NULL, NULL, NULL, NULL, NULL, NULL, 8, 2),
     ('Текст отзыва Киноакадемии России к фильму Замужем за мафией', NULL, NULL, NULL, NULL, NULL, NULL, 8, 3),
     (NULL, NULL, NULL, NULL, NULL, TRUE, NULL, 8, 4),
     (NULL, NULL, NULL, NULL, NULL, TRUE, NULL, 8, 5),
     (NULL, NULL, NULL, NULL, NULL, TRUE, NULL, 8, 6),
     (NULL, NULL, NULL, NULL, NULL, NULL, '2023-06-10', 8, 7),
     (NULL, NULL, NULL, NULL, NULL, NULL, '2023-06-11', 8, 8),
     (NULL, NULL, NULL, NULL, NULL, NULL, '2023-06-12', 8, 9),
     (NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-18', 8, 10),
     (NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-18', 8, 11),
     (NULL, NULL, NULL, NULL, NULL, NULL, '2023-04-07', 8, 12),

     ('Текст рецензии журнала Огонек к фильму Тобол', NULL, NULL, NULL, NULL, NULL, NULL, 9, 1),
     ('Текст рецензии журнала Мосфильм к фильму Тобол', NULL, NULL, NULL, NULL, NULL, NULL, 9, 2),
     ('Текст отзыва Киноакадемии России к фильму Тобол', NULL, NULL, NULL, NULL, NULL, NULL, 9, 3),
     (NULL, NULL, NULL, NULL, NULL, FALSE, NULL, 9, 4),
     (NULL, NULL, NULL, NULL, NULL, TRUE, NULL, 9, 5),
     (NULL, NULL, NULL, NULL, NULL, FALSE, NULL, 9, 6),
     (NULL, NULL, NULL, NULL, NULL, NULL, '2023-07-11', 9, 7),
     (NULL, NULL, NULL, NULL, NULL, NULL, '2023-07-12', 9, 8),
     (NULL, NULL, NULL, NULL, NULL, NULL, '2023-07-13', 9, 9),
     (NULL, NULL, NULL, NULL, NULL, NULL, '2023-04-07', 9, 10),
     (NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-18', 9, 11),
     (NULL, NULL, NULL, NULL, NULL, NULL, '2023-04-07', 9, 12);


-- View сборки служебных данных

CREATE OR REPLACE VIEW service_assembly AS WITH current_tasks AS (SELECT fa.film_id, a.name AS attribute, fa.date_value FROM film_attribute_values AS fa JOIN attributes AS a ON fa.attribute_id=a.id JOIN attribute_types AS at ON at.id=a.attribute_type_id WHERE at.name='serviceDate' AND fa.date_value=current_date),
    future_tasks AS (SELECT fa.film_id, a.name AS attribute, fa.date_value FROM film_attribute_values AS fa JOIN attributes AS a ON fa.attribute_id=a.id JOIN attribute_types AS at ON at.id=a.attribute_type_id WHERE at.name='serviceDate' AND fa.date_value=(NOW()::DATE + 20))
SELECT (SELECT name FROM films WHERE id=COALESCE(ct.film_id, ft.film_id)) AS film, ct.attribute AS task_now, ft.attribute AS task_20 FROM current_tasks AS ct FULL JOIN future_tasks AS ft ON ct.film_id=ft.film_id;

-- View сборки данных для маркетинга

CREATE OR REPLACE VIEW marketing_assembly AS SELECT f.name AS film, at.name AS attribute_type, a.name AS attribute, fa.text_value, fa.bool_value, fa.date_value FROM films AS f JOIN film_attribute_values AS fa ON f.id=fa.film_id JOIN attributes AS a ON fa.attribute_id=a.id JOIN attribute_types AS at ON at.id=a.attribute_type_id;
