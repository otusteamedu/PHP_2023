/* фильм, задачи актуальные на сегодня, задачи актуальные через 20 дней */

CREATE VIEW services_data AS
SELECT m.name           AS movie,
       CASE WHEN v.value_date = (SELECT CURRENT_DATE)
                THEN a.description
            ELSE '' END AS "today's tasks",
       CASE WHEN v.value_date = (SELECT CURRENT_DATE + 20)
                THEN a.description
            ELSE '' END AS "tasks in 20 days"
FROM value v
     JOIN movie m
          ON v.movie_id = m.id
     JOIN attribute a
          ON v.attribute_id = a.id
     JOIN attribute_type at
          ON at.id = a.attribute_type AND at.name = 'date'
WHERE v.value_date = (SELECT CURRENT_DATE)
   OR v.value_date = (SELECT CURRENT_DATE + 20)
ORDER BY movie_id;

SELECT *
FROM services_data;

/* фильм, тип атрибута, атрибут, значение (значение выводим как текст) */

CREATE VIEW marketing_data AS
SELECT m.name        AS movie,
       at.name       AS attribute_type,
       a.description AS attribute,
       COALESCE(
               v.value_text,
               v.value_boolean,
               v.value_integer,
               v.value_float,
               v.value_date
       )::text       AS value
FROM value v
     JOIN movie m
          ON v.movie_id = m.id
     JOIN attribute a
          ON v.attribute_id = a.id
     JOIN attribute_type at
          ON at.id = a.attribute_type
ORDER BY movie_id;

SELECT *
FROM marketing_data;
