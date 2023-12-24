CREATE VIEW "view1" AS

SELECT m.name                     AS фильм,
       types.type                 AS тип,
       attributes.name            AS атрибут,
       COALESCE(
               values.value_string,
               values.value_int::text,
               values.value_timestamp::text,
               values.value_boolean::text,
               values.value_text) AS значение
FROM movies m
         JOIN movies_attributes_values values ON values.movie_id = m.id
         JOIN movies_attributes attributes ON attributes.id = values.movies_attributes_id
         JOIN movies_attributes_types types ON types.id = attributes.movies_attributes_type_id
ORDER BY m.name;



CREATE VIEW "view2" AS
SELECT m.name                                        AS фильм,
       attributes.name                               AS атрибут,
       CASE
           WHEN values.value_timestamp::date = CURRENT_TIMESTAMP::date
               THEN values.value_timestamp::date END AS Сегодня,
       CASE
           WHEN values.value_timestamp::date = CURRENT_TIMESTAMP::date + INTERVAL '20 days'
               THEN values.value_timestamp::date END AS "Через 20 дней"

FROM movies m
         JOIN movies_attributes_values values ON values.movie_id = m.id
         JOIN movies_attributes attributes ON attributes.id = values.movies_attributes_id
         JOIN movies_attributes_types types ON types.id = attributes.movies_attributes_type_id
WHERE types.id = 4;

