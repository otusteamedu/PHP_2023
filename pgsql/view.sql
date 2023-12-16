CREATE VIEW service_data AS
SELECT f.title, av.attribute_value AS today_tasks, av2.attribute_value AS tasks_after_20_days
FROM films f
         LEFT JOIN attribute_values av ON f.film_id = av.film_id AND av.attribute_id = 4
         LEFT JOIN attribute_values av2 ON f.film_id = av2.film_id AND av2.attribute_id = 4
    AND
    (
    values.attribute_value_time_tz:: date = CURRENT_DATE
    OR
    values.attribute_value_time_tz:: date =(CURRENT_DATE + interval '20' day)
    );

CREATE VIEW marketing_data AS
SELECT f.title,
       at.attribute_type_name,
       atr.attribute_name,
       CASE
           WHEN attr_types.value_column_name = 'attribute_value_text' THEN values.value_text
           WHEN attr_types.value_column_name = 'attribute_value_bool' THEN values.value_bool::text
           WHEN attr_types.value_column_name = 'attribute_value_date' THEN values.value_date::text
           WHEN attr_types.value_column_name = 'attribute_value_time_tz' THEN values.value_date_tz::text
           WHEN attr_types.value_column_name = 'attribute_value_int' THEN values.value_int::text
           END value
FROM films f
JOIN attribute_values av ON f.film_id = av.film_id
JOIN attributes atr ON av.attribute_id = atr.attribute_id
JOIN attribute_types at ON atr.attribute_type_id = at.attribute_type_id;
