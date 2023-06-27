-- Important dates
CREATE VIEW important_dates AS
SELECT
    m.name,
    array_agg(CASE WHEN v.date_value = CURRENT_DATE THEN a.name END) current_tasks,
    array_agg(CASE WHEN v.date_value BETWEEN CURRENT_DATE AND (CURRENT_DATE + INTERVAL '20 days') THEN a.name END) tasks_in_20_days
FROM movie m
         INNER JOIN value v on m.id = v.movie_id
         INNER JOIN attribute a on v.attribute_id = a.id
WHERE v.attribute_id IN (4, 5) -- Важные даты
GROUP BY m.name;

SELECT * FROM important_dates;

-- Marketing data
CREATE VIEW marketing_data AS
SELECT m.name movie, at.name attribute_type, a.name attribute,
       CASE
           WHEN at.name = 'text' THEN v.text_value::text
           WHEN at.name = 'boolean' THEN v.boolean_value::text
           WHEN at.name = 'date' THEN v.date_value::text
           END value
FROM movie m
         INNER JOIN value v on m.id = v.movie_id
         INNER JOIN attribute a on a.id = v.attribute_id
         INNER JOIN attribute_type at on at.id = a.type_id;

SELECT * FROM marketing_data;
