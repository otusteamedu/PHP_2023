CREATE VIEW marketing_data_assembly AS
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
