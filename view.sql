CREATE VIEW Marketing AS
SELECT title     AS фильм,
       type_name AS тип_атрибута,
       attr_name AS атрибут,
       value     AS значение
FROM movies m
         INNER JOIN values_attributes va
                    ON
                        m.movie_id = va.v_movie_id
         INNER JOIN names_attributes na
                    ON
                        va.v_attr_id = na.attr_id
         INNER JOIN types_attributes ta
                    ON
                        na.attr_type_id = ta.type_id;

CREATE VIEW Service_data AS
SELECT title                                                                                  AS фильм,
       CASE WHEN va.value::date = CURRENT_DATE THEN va.value ELSE '' END                      AS Сегодня,
       CASE WHEN va.value::date = CURRENT_DATE + INTERVAL '20 days' THEN va.value ELSE '' END AS "Задачи через 20 дней"
FROM movies m
         INNER JOIN values_attributes va
                    ON
                        m.movie_id = va.v_movie_id
         INNER JOIN names_attributes na
                    ON
                        va.v_attr_id = na.attr_id
         INNER JOIN types_attributes ta
                    ON
                        na.attr_type_id = ta.type_id
WHERE ta.type_id = 1;