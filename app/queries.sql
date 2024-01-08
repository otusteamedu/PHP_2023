/* фильм, задачи актуальные на сегодня, задачи актуальные через 20 дней */

SELECT m.name AS movie, a.description AS attribute, v.value
FROM value v
     JOIN movie m ON v.movie_id = m.id
     JOIN attribute a ON v.attribute_id = a.id
     JOIN attribute_type at ON at.id = a.attribute_type AND at.name = 'date'
WHERE v.value = (SELECT CURRENT_DATE)::text OR v.value = (SELECT CURRENT_DATE + 20)::text
ORDER BY movie_id;

/* фильм, тип атрибута, атрибут, значение (значение выводим как текст) */

SELECT m.name AS movie, at.name AS attribute_type, a.description AS attribute, v.value::text
FROM value v
     JOIN movie m ON v.movie_id = m.id
     JOIN attribute a ON v.attribute_id = a.id
     JOIN attribute_type at ON at.id = a.attribute_type
ORDER BY movie_id;
