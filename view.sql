DROP VIEW IF EXISTS Marketing;
DROP VIEW IF EXISTS Service_data;


CREATE VIEW Marketing AS
SELECT movie_name AS movie_name,
       attr_type_name AS date_type,
       attr_name AS attribute,
       COALESCE(attr_value_str, attr_value_int::text, attr_value_bool::text, attr_value_date::text, attr_value_float::text) AS value
FROM movies m
         INNER JOIN attributes_values av
                    ON
                        m.movie_id = av.attr_val_movie_id
         INNER JOIN attributes_names an
                    ON
                        av.attr_type_id = an.attr_name_id
         INNER JOIN attributes_type at2
                    ON
                        an.attr_type_id  = at2.attr_type_id;
                        
                       
CREATE VIEW Service_data AS
SELECT movie_name AS movie_name,
       CASE WHEN av.attr_value_date = CURRENT_DATE THEN an.attr_name END AS Сегодня,
       CASE WHEN av.attr_value_date = CURRENT_DATE + INTERVAL '20 days' THEN an.attr_name END AS "Задачи через 20 дней"
FROM movies m
         INNER JOIN attributes_values av
                    ON
                        m.movie_id = av.attr_val_movie_id
         INNER JOIN attributes_names an
                    ON
                        av.attr_type_id = an.attr_name_id
         INNER JOIN attributes_type at2
                    ON
                        an.attr_type_id  = at2.attr_type_id
WHERE at2.attr_type_id = 1;