CREATE VIEW service_data AS
SELECT my_presorted_table.name, my_presorted_table.attr_name, my_presorted_table.my_text
FROM (
         SELECT movie.name,
                ma.attr_name,
                CONCAT('сегодня в: ', to_char(mav.value_date, 'HH24:MI:SS')) as my_text,
                mav.value_date
         FROM movie
                  LEFT JOIN movie_attribute ma on movie.id = ma.movie_id
                  LEFT JOIN movie_attribute_types mat on mat.id = ma.attr_type
                  LEFT JOIN movie_attribute_value mav on ma.attr_id = mav.attr_id
         WHERE mat.name = 'дата служебная' AND
                 date_trunc('day', mav.value_date) = date_trunc('day', now())
         UNION
         SELECT movie.name,
                ma.attr_name,
                CONCAT('через 20 дней: ',
                       to_char(mav.value_date, 'DD.MM.YYYY HH24:MI:SS')) as my_text,
                mav.value_date
         FROM movie
                  INNER JOIN movie_attribute ma on movie.id = ma.movie_id
                  INNER JOIN movie_attribute_types mat on mat.id = ma.attr_type
                  INNER JOIN movie_attribute_value mav on ma.attr_id = mav.attr_id
         where mat.name = 'дата служебная' AND
                 EXTRACT(EPOCH FROM mav.value_date) >= EXTRACT(EPOCH FROM NOW() + INTERVAL '+20 days')
     ) my_presorted_table
ORDER BY my_presorted_table.value_date ASC;