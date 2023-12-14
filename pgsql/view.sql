CREATE VIEW marketing_data_view AS
SELECT
    m.title AS movie,
    t.attribute_type,
    a.attribute,
    COALESCE(v.text_value, v.boolean_value::TEXT, v.date_value::TEXT, v.float_value::TEXT, v.int_value::TEXT) AS value
FROM
    movies m
JOIN
    values v ON m.id = v.movie_id
JOIN
    attributes a ON v.attribute_id = a.id
JOIN
    attribute_types t ON a.attribute_type_id = t.id;


CREATE VIEW service_data_view AS
SELECT
    m.title AS movie,
    a.attribute AS tasks_actual_today,
    a.attribute AS tasks_actual_in_20_days
FROM
    movies m
        JOIN
    values v ON m.id = v.movie_id
        JOIN
    attributes a ON v.attribute_id = a.id
        JOIN
    attribute_types t ON a.attribute_type_id = t.id
WHERE
    t.attribute_type = 'service dates' AND
    (v.date_value = CURRENT_DATE OR v.date_value = CURRENT_DATE + INTERVAL '20 days');