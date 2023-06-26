-- View for tasks on today

CREATE VIEW tasks_today AS
SELECT m.name AS movie_name,
    a_t.name AS attribute_type,
    a.name AS attribute,
    "v".v_date AS value_date
FROM ((("_values" "v"
    LEFT JOIN movies m ON ((m.id = "v".movie_id)))
    LEFT JOIN attributes a ON ((a.id = "v".attribute_id)))
    LEFT JOIN attribute_types a_t ON ((a_t.id = a.attribute_type_id)))
WHERE (((a_t.name)::text = 'service_dates'::text) AND ("v".v_date = CURRENT_DATE));

-- View for tasks relevant after 20 days

CREATE VIEW tasks_relevant_in_future AS
SELECT m.name AS movie_name,
    a_t.name AS attribute_type,
    a.name AS attribute_name,
    "v".v_date AS value_date
FROM ((("_values" "v"
    LEFT JOIN movies m ON ((m.id = "v".movie_id)))
    LEFT JOIN attributes a ON ((a.id = "v".attribute_id)))
    LEFT JOIN attribute_types a_t ON ((a_t.id = a.attribute_type_id)))
WHERE (((a_t.name)::text = 'service_dates'::text) AND ("v".v_date > (CURRENT_DATE + 20)));

-- View for marketing

CREATE VIEW marketing AS
SELECT m.name AS movie_name,
    concat(a_t.name, ' - ', a.name) AS attribute,
    "v".v_text,
    "v".v_bool,
    "v".v_date
FROM ((("_values" "v"
    LEFT JOIN movies m ON ((m.id = "v".movie_id)))
    LEFT JOIN attributes a ON ((a.id = "v".attribute_id)))
    LEFT JOIN attribute_types a_t ON ((a_t.id = a.attribute_type_id)));