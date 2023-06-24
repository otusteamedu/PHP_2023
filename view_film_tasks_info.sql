CREATE VIEW film_tasks_info AS
SELECT
    f.name AS film_name,
    array_agg(CASE WHEN a_v.date_value = CURRENT_DATE THEN a_v.text_value END) AS current_tasks,
    array_agg(CASE WHEN a_v.date_value > CURRENT_DATE AND a_v.date_value <= CURRENT_DATE + INTERVAL '20 days' THEN a_v.text_value END) AS future_tasks
FROM
    films f
        JOIN attribute_values a_v ON f.id = a_v.film_id
        JOIN attributes a ON a_v.attribute_id = a.id
WHERE
        a.name = 'Task'
GROUP BY
    f.id;