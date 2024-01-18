CREATE VIEW Marketing AS
SELECT title AS фильм,
       type_name AS тип_атрибута,
       attr_name AS атрибут,
       COALESCE(value_text, value_date::text, value_int::text, value_float::text, value_bool::text) AS значение
FROM movies m
         INNER JOIN values_attributes va ON m.movie_id = va.v_movie_id
         INNER JOIN names_attributes na ON va.v_attr_id = na.attr_id
         INNER JOIN types_attributes ta ON na.attr_type_id = ta.type_id;

CREATE VIEW Service_data AS
SELECT title AS фильм,
       CASE WHEN va.value_date = CURRENT_DATE THEN va.value_date END AS Сегодня,
       CASE WHEN va.value_date = CURRENT_DATE + INTERVAL '20 days' THEN va.value_date END AS "Задачи через 20 дней"
        FROM movies m
        INNER JOIN values_attributes va ON m.movie_id = va.v_movie_id
        INNER JOIN names_attributes na ON va.v_attr_id = na.attr_id
        INNER JOIN types_attributes ta ON na.attr_type_id = ta.type_id
        WHERE ta.type_id = 1;