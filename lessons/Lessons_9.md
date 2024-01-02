# 9. Работа с окружением

### Описание/Пошаговая инструкция выполнения домашнего задания:
Спроектировать EAV-хранение для базы данных кинотеатра
4 таблицы: фильмы, атрибуты, типы атрибутов, значения.
Типы атрибутов и соответствующие им атрибуты (для примера):

рецензии (текстовые значения) - рецензии критиков, отзыв неизвестной киноакадемии ...
премия (заменяется при печати баннеров и билетов на изображение, логическое значение) - оскар, ника ...
"важные даты" даты (при печати - наименование атрибута и значение даты, тип дата) - мировая премьера, премьера в РФ ...
служебные даты (используются при планировании, тип дата) - дата начала продажи билетов, когда запускать рекламу на ТВ ...
View сборки служебных данных в форме:
фильм, задачи актуальные на сегодня, задачи актуальные через 20 дней
View сборки данных для маркетинга в форме (три колонки):
фильм, тип атрибута, атрибут, значение (значение выводим как текст)


# Решение

### Сущности
```sql
CREATE TABLE movies
(
    id SERIAL PRIMARY KEY
);



CREATE TABLE types
(
    id        SERIAL PRIMARY KEY,
    type_name VARCHAR(255) NOT NULL
);


CREATE TABLE attributes
(
    id      SERIAL PRIMARY KEY,
    name    VARCHAR(255) NOT NULL,
    type_id INTEGER      NOT NULL,
    FOREIGN KEY (type_id) REFERENCES types (id)
);


CREATE TABLE values
(
    id     SERIAL PRIMARY KEY,
    movie_id     INTEGER NOT NULL,
    attribute_id INTEGER NOT NULL,
    value         VARCHAR(255)    NOT NULL,
    FOREIGN KEY (movie_id) REFERENCES movies (id),
    FOREIGN KEY (attribute_id) REFERENCES attributes (id)
);


INSERT INTO movies VALUES (DEFAULT), (DEFAULT), (DEFAULT), (DEFAULT);


INSERT INTO types (type_name)
VALUES ('Текст'),
       ('Логическое'),
       ('Дата');


INSERT INTO attributes (name, type_id)
VALUES ('Рецензии', 1),
       ('Премия', 2),
       ('Важные даты', 3),
       ('Служебные даты', 3);


INSERT INTO values (movie_id, attribute_id, value) VALUES
                                                       (1, 1, 'Отличный фильм, захватывающий сюжет'),
                                                       (1, 2, 'true'),
                                                       (1, 3, '2023-01-01'),
                                                       (1, 4, '2022-12-01');

INSERT INTO values (movie_id, attribute_id, value) VALUES
                                                       (2, 1, 'Увлекательная история, прекрасная игра актёров'),
                                                       (2, 2, 'false'),
                                                       (2, 3, '2023-05-01'),
                                                       (2, 4, '2023-04-01');


INSERT INTO values (movie_id, attribute_id, value) VALUES
                                                       (3, 1, 'Увлекательная история, прекрасная игра актёров фильма 3'),
                                                       (3, 2, 'false'),
                                                       (3, 3, '2023-05-01'),
                                                       (3, 4, '2024-01-02');


INSERT INTO values (movie_id, attribute_id, value) VALUES
                                                       (4, 1, 'Увлекательная история, прекрасная игра актёров фильма 4'),
                                                       (4, 2, 'false'),
                                                       (4, 3, '2023-05-01'),
                                                       (4, 4, '2024-01-22');
```


### Поиск
```sql
-- важные даты
SELECT  v.value AS "Сегодня", v2.value AS "Через 20 дней"
FROM movies m
         LEFT JOIN values v ON m.id = v.movie_id AND v.attribute_id = 4 AND TO_CHAR(NOW() :: DATE, 'YYYY-MM-DD') = v.value
         LEFT JOIN values v2 ON m.id = v2.movie_id AND v2.attribute_id = 4 AND v2.value = TO_CHAR(NOW()  :: DATE + INTERVAL '20 days', 'YYYY-MM-DD');


-- marketing
SELECT a.name as attribute, v.value
FROM movies m
         JOIN values v ON m.id = v.movie_id
         JOIN attributes a ON v.attribute_id = a.id
         JOIN types t ON a.id = t.id;
```