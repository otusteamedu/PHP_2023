CREATE VIEW marketing_data AS
SELECT movie.name,
       CONCAT(mat.name, ' ', ma.attr_name) as type_attr_name,
       CASE
           WHEN mat.name='текст'
               THEN CAST(mav.value_text as varchar)
           WHEN mat.name='булево'
               THEN CAST(mav.value_bool as varchar)
           WHEN mat.name='дата'
               THEN CAST(mav.value_date as varchar)
           END as value_data
FROM movie
         LEFT JOIN movie_attribute ma on movie.id = ma.movie_id
         LEFT JOIN movie_attribute_types mat on mat.id = ma.attr_type
         LEFT JOIN movie_attribute_value mav on ma.attr_id = mav.attr_id
WHERE mat.name != 'дата служебная'
ORDER BY movie.id;