-- Создание представления для сборки служебных данных
CREATE VIEW service_data AS
SELECT f.title, av.attribute_value AS today_tasks, av2.attribute_value AS tasks_after_20_days
FROM Movies f
         LEFT JOIN Values av ON f.movie_id = av.movie_id AND av.attribute_id = 3
         LEFT JOIN Values av2 ON f.movie_id = av2.movie_id AND av2.attribute_id = 3
    AND
                                 (
                                             av.value:: date = CURRENT_DATE
                                         OR
                                             av.value:: date =
                                             (CURRENT_DATE + interval '20' day)
                                     );

-- Создание представления для сборки данных для маркетинга
CREATE VIEW marketing_data AS
SELECT f.title,
       at.type_name AS attribute_type_name,
       atr.attribute_name,
       CASE
           WHEN at.type_name = 'Text' THEN val.value_text
           WHEN at.type_name = 'Image' THEN val.value_bool::text
           WHEN at.type_name = 'Date' THEN val.value_date::text
           END      AS value
FROM Movies f
         JOIN Values val ON f.movie_id = val.movie_id
         JOIN Attributes atr ON val.attribute_id = atr.attribute_id
         JOIN AttributeTypes at ON atr.type_id = at.type_id;