INSERT into "moviesAttributesTypes" (type) VALUES
('служебные даты'), ('премии'), ('рецензии');

#id |      type
#----+----------------
#  1 | служебные даты
#  2 | премии
#  3 | рецензии

INSERT into "moviesAttributes" (type_id, name) VALUES
(1, 'старт продаж билетов'), (1, 'старт запуска рекламы на ТВ'), (2, 'Оскар'), (3, 'Пальмовая ветвь');

#id | type_id |            name
#----+---------+-----------------------------
#  1 |       1 | старт продаж билетов
#  2 |       1 | старт запуска рекламы на ТВ
#  3 |       2 | Оскар
#  4 |       3 | Пальмовая ветвь

INSERT into movies (name) VALUES
('my'), ('my1'), ('my2') ('my3');
#id | name
#----+------
#  2 | my
#  3 | my1
#  4 | my2
#  5 | my3

INSERT into "moviesAttributesValues" (movie_id, movies_attr_id, v_timestamp) VALUES
(3, 1, NOW()), (2, 1, NOW()), (4, 1, '2023-10-10');

INSERT into "moviesAttributesValues" (movie_id, movies_attr_id, v_bool) VALUES
(4, 3, true), (2, 4, true);

#id | movie_id | movies_attr_id | v_text | v_int |        v_timestamp         | v_bool
#----+----------+----------------+--------+-------+----------------------------+--------
#  4 |        3 |              1 |        |       | 2023-09-19 21:47:25.213022 |
#  5 |        2 |              1 |        |       | 2023-09-19 21:47:25.213022 |
#  6 |        4 |              1 |        |       | 2023-10-10 00:00:00        |
#  7 |        4 |              3 |        |       |                            | t
#  8 |        2 |              4 |        |       |                            | t


#View сборки данных для маркетинга в форме: фильм, тип атрибута, атрибут, значение (значение выводим как текст)
SELECT movies.name as фильм, CONCAT(mat.type, ': ' , ma.name) as атрибут,
CONCAT(mav.v_bool::text, mav.v_timestamp::text, mav.v_float::text) as значение  FROM movies
LEFT JOIN "moviesAttributesValues" as mav ON movies.id = movie_id
LEFT JOIN "moviesAttributes" as ma ON mav.movies_attr_id = ma.id
LEFT JOIN "moviesAttributesTypes" as mat ON ma.type_id = mat.id
ORDER BY фильм;

#фильм |               атрибут                |          значение
-------+--------------------------------------+----------------------------
# my    | служебные даты: старт продаж билетов | 2023-09-19 21:47:25.213022
# my    | премии: Пальмовая ветвь            | true
# my1   | служебные даты: старт продаж билетов | 2023-09-19 21:47:25.213022
# my2   | служебные даты: старт продаж билетов | 2023-10-10 00:00:00
# my2   | премии: Оскар                        | true
# my3   | :                                    |
#(6 rows)

#View сборки служебных данных в форме:
#фильм, задачи актуальные на сегодня,
SELECT movies.name as фильм, CONCAT(mat.type, ': ' , ma.name) as "задачи актуальные на сегодня",
mav.v_timestamp as дата  FROM movies
LEFT JOIN "moviesAttributesValues" as mav ON movies.id = movie_id
LEFT JOIN "moviesAttributes" as ma ON mav.movies_attr_id = ma.id
LEFT JOIN "moviesAttributesTypes" as mat ON ma.type_id = mat.id
WHERE v_timestamp::date = CURRENT_TIMESTAMP::date
ORDER BY фильм;

#фильм |     задачи актуальные на сегодня     |            дата
#-------+--------------------------------------+----------------------------
# my    | служебные даты: старт продаж билетов | 2023-09-19 21:47:25.213022
# my1   | служебные даты: старт продаж билетов | 2023-09-19 21:47:25.213022

#задачи актуальные через 20 дней
SELECT movies.name as фильм, CONCAT(mat.type, ': ' , ma.name) as "задачи актуальные через 20 дней",
mav.v_timestamp as дата  FROM movies
LEFT JOIN "moviesAttributesValues" as mav ON movies.id = movie_id
LEFT JOIN "moviesAttributes" as ma ON mav.movies_attr_id = ma.id
LEFT JOIN "moviesAttributesTypes" as mat ON ma.type_id = mat.id
WHERE v_timestamp::date >= (CURRENT_TIMESTAMP + interval '20 days')::date
ORDER BY фильм;

#ответ на вопрос как хранить float и bool (см. последние два столбца):
ALTER TABLE "moviesAttributesValues" ADD column v_float float;
SELECT * FROM "moviesAttributesValues";

#id | movie_id | movies_attr_id | v_text | v_int |        v_timestamp         | v_bool | v_float
#----+----------+----------------+--------+-------+----------------------------+--------+---------
#  4 |        3 |              1 |        |       | 2023-09-19 21:47:25.213022 |        |
#  5 |        2 |              1 |        |       | 2023-09-19 21:47:25.213022 |        |
#  6 |        4 |              1 |        |       | 2023-10-10 00:00:00        |        |
#  7 |        4 |              3 |        |       |                            | t      |
#  8 |        2 |              4 |        |       |                            | t      |
#(5 rows)

INSERT into "moviesAttributesValues" (movie_id, movies_attr_id, v_float) VALUES (2, 5, 4.23);
SELECT * FROM "moviesAttributesValues";

#id | movie_id | movies_attr_id | v_text | v_int |        v_timestamp         | v_bool | v_float
#----+----------+----------------+--------+-------+----------------------------+--------+---------
#  4 |        3 |              1 |        |       | 2023-09-19 21:47:25.213022 |        |
#  5 |        2 |              1 |        |       | 2023-09-19 21:47:25.213022 |        |
#  6 |        4 |              1 |        |       | 2023-10-10 00:00:00        |        |
#  7 |        4 |              3 |        |       |                            | t      |
#  8 |        2 |              4 |        |       |                            | t      |
#  9 |        2 |              5 |        |       |                            |        |    4.23

SELECT movies.name as фильм, CONCAT(mat.type, ': ' , ma.name) as атрибут,
CONCAT(mav.v_bool::text, mav.v_timestamp::text, mav.v_float::text) as значение  FROM movies
LEFT JOIN "moviesAttributesValues" as mav ON movies.id = movie_id
LEFT JOIN "moviesAttributes" as ma ON mav.movies_attr_id = ma.id
LEFT JOIN "moviesAttributesTypes" as mat ON ma.type_id = mat.id
ORDER BY фильм;
#фильм |                атрибут                 |          значение
#-------+----------------------------------------+----------------------------
# my    | рецензии: Пальмовая ветвь              | true
# my    | средняя оценка зрителей: статистика вк | 4.23
# my    | служебные даты: старт продаж билетов   | 2023-09-19 21:47:25.213022
# my1   | служебные даты: старт продаж билетов   | 2023-09-19 21:47:25.213022
# my2   | премии: Оскар                          | true
# my2   | служебные даты: старт продаж билетов   | 2023-10-10 00:00:00
# my3   | :                                      |
#(7 rows)
