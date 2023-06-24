CREATE VIEW marketing_data AS
SELECT f.name AS film, a_t.name AS attribute_type, a.name AS attribute,
    CASE
        WHEN a_v.text_value IS NOT NULL THEN a_v.text_value::text
        WHEN a_v.integer_value IS NOT NULL THEN a_v.integer_value::text
        WHEN a_v.decimal_value IS NOT NULL THEN a_v.decimal_value::text
        WHEN a_v.date_value IS NOT NULL THEN a_v.date_value::text
        WHEN a_v.boolean_value IS NOT NULL THEN a_v.boolean_value::text
    END AS value
FROM films f
JOIN attribute_values a_v ON a_v.film_id = f.id
JOIN attributes a ON a.id = a_v.attribute_id
JOIN attribute_types a_t ON a_t.id = a.type_id;
