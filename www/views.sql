CREATE VIEW "vw_marketing" AS
SELECT movies.name AS movie_name,
       concat('(', attributes_type.name, ')', ' ', attributes.name) AS attribute,
       COALESCE(attributes_values.val_num::text, attributes_values.val_money::text, attributes_values.val_text) AS attr_val
FROM attributes_values
         LEFT JOIN movies ON movies.id = attributes_values.movie_id
         LEFT JOIN attributes ON attributes.id = attributes_values.attribute_id
         LEFT JOIN attributes_type ON attributes_type.id = attributes.attribute_type_id
ORDER BY attributes_type.name;


CREATE VIEW "vw_sessions_schedule" AS WITH sessions_today AS (
    SELECT halls.name AS hall,
           movies.name AS movie_name,
           sessions.datetime
    FROM halls
             LEFT JOIN sessions ON halls.id = sessions.hall_id
             LEFT JOIN movies ON sessions.movie_id = movies.id
    WHERE sessions.datetime > '2024-01-04 00:00:00'::timestamp without time zone AND sessions.datetime < '2024-01-04 23:59:59'::timestamp without time zone
    ), sessions_after_20_days AS (
SELECT halls.name AS hall,
    movies.name AS movie_name,
    sessions.datetime
FROM halls
    LEFT JOIN sessions ON halls.id = sessions.hall_id
    LEFT JOIN movies ON sessions.movie_id = movies.id
WHERE sessions.datetime > ('2024-01-04 00:00:00'::timestamp without time zone + '20 days'::interval) AND sessions.datetime < ('2024-01-04 23:59:59'::timestamp without time zone + '20 days'::interval)
    )
SELECT sessions_today.hall,
       sessions_today.movie_name,
       sessions_today.datetime AS session_today_time,
       sessions_after_20_days.datetime AS session_after_20_days_time
FROM sessions_today
         LEFT JOIN sessions_after_20_days ON sessions_today.hall = sessions_after_20_days.hall AND sessions_today.movie_name = sessions_after_20_days.movie_name
ORDER BY sessions_today.datetime;