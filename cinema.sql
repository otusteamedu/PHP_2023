CREATE TABLE IF NOT EXISTS movies
(
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

INSERT INTO movies (name)
VALUES ('Фильм №1'),
       ('Фильм №2');

-- #####################################################################################################################

CREATE TABLE IF NOT EXISTS attribute_types
(
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

INSERT INTO attribute_types (name)
VALUES ('TEXT'),
       ('BOOL'),
       ('DATE'),
       ('DOUBLE'),
       ('INT');

-- #####################################################################################################################

CREATE TABLE IF NOT EXISTS movie_attributes
(
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    attribute_type_id INTEGER NOT NULL REFERENCES attribute_types (id)
);

INSERT INTO movie_attributes (name, attribute_type_id)
VALUES ('Рецензии критиков', 1),
       ('Премия оскар', 2),
       ('Премьера в РФ', 3),
       ('Дата начала продажи билетов', 3);

-- #####################################################################################################################

CREATE TABLE IF NOT EXISTS movie_values
(
    id SERIAL PRIMARY KEY,
    movie_id INTEGER NOT NULL REFERENCES movies (id),
    movie_attribute_id INTEGER NOT NULL REFERENCES movie_attributes (id),
    value_text TEXT DEFAULT NULL,
    value_date DATE DEFAULT NULL,
    value_boolean BOOLEAN DEFAULT NULL,
    value_double DOUBLE PRECISION DEFAULT NULL,
    value_int INTEGER DEFAULT NULL
);

CREATE INDEX "movie_values-movie_id-movie_attribute_id-idx" ON movie_values USING btree (movie_id, movie_attribute_id);

INSERT INTO movie_values (movie_id, movie_attribute_id, value_text, value_date, value_boolean)
VALUES (1, 1, 'Рецензии критиков', NULL, NULL),
       (1, 2, NULL, NULL, true),
       (1, 3, NULL, '2023-10-20', NULL),
       (1, 4, NULL, '2023-10-21', NULL),
       (2, 1, 'Рецензии критиков', NULL, NULL),
       (2, 2, NULL, NULL, false),
       (2, 3, NULL, '2023-10-22', NULL),
       (2, 4, NULL, '2023-10-23', NULL);

-- #####################################################################################################################

-- фильм, тип атрибута, атрибут, значение (значение выводим как текст)
CREATE VIEW movie_values_view AS
SELECT movies.name as movie_name,
       attribute_types.name as attribute_type,
       movie_attributes.name as attribute_name,
       CASE
           WHEN attribute_types.name = 'TEXT' THEN movie_values.value_text
           WHEN attribute_types.name = 'DOUBLE' THEN (movie_values.value_double)::text
           WHEN attribute_types.name = 'INT' THEN (movie_values.value_int)::text
           WHEN attribute_types.name = 'DATE' THEN (movie_values.value_date)::text
           WHEN attribute_types.name = 'BOOL' THEN
               CASE
                   WHEN movie_values.value_boolean = true THEN 'Да'
                   WHEN movie_values.value_boolean = false THEN 'Нет'
               END
       END as value
FROM movie_values
LEFT JOIN movies on movie_values.movie_id = movies.id
LEFT JOIN movie_attributes on movie_values.movie_attribute_id = movie_attributes.id
LEFT JOIN attribute_types on movie_attributes.attribute_type_id = attribute_types.id;

-- фильм, задачи актуальные на сегодня
CREATE VIEW movies_values_today_view AS
SELECT movie_name, attribute_type, attribute_name, value from movie_values_view
WHERE attribute_type = 'DATE' AND to_date(value, 'YYYY-MM-DD') = current_date;

-- фильм, задачи актуальные через 20 дней
CREATE VIEW movies_values_after_20_days_view AS
SELECT movie_name, attribute_type, attribute_name, value from movie_values_view
WHERE attribute_type = 'DATE' AND to_date(value, 'YYYY-MM-DD') >= current_date + 20;