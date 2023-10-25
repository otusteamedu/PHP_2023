CREATE VIEW "marketing_view" AS
SELECT films.name AS film_name, CONCAT('(' , attributes_type.name, ')', ' ', attributes.name) as attribute,
       COALESCE(
               attributes_values.val_num::text,
               attributes_values.val_money::text,
               attributes_values.val_text
           ) AS attr_val
FROM attributes_values
         LEFT JOIN films ON films.id = attributes_values.film_id
         LEFT JOIN attributes ON attributes.id = attributes_values.attribute_id
         LEFT JOIN attributes_type ON attributes_type.id = attributes.type_id
ORDER BY attributes_type.name;

CREATE VIEW "sessions_schedule_view" AS WITH sessions_today AS (
         SELECT halls.name AS hall,
            films.name AS film_name,
            sessions.datetime
           FROM ((halls
             LEFT JOIN sessions ON ((halls.id = sessions.hall_id)))
             LEFT JOIN films ON ((sessions.film_id = films.id)))
          WHERE ((sessions.datetime > '2023-10-22 00:00:00'::timestamp without time zone) AND (sessions.datetime < '2023-10-22 23:59:59'::timestamp without time zone))
        ), sessions_after_20_days AS (
         SELECT halls.name AS hall,
            films.name AS film_name,
            sessions.datetime
           FROM ((halls
             LEFT JOIN sessions ON ((halls.id = sessions.hall_id)))
             LEFT JOIN films ON ((sessions.film_id = films.id)))
          WHERE ((sessions.datetime > ('2023-10-22 00:00:00'::timestamp without time zone + '20 days'::interval)) AND (sessions.datetime < ('2023-10-22 23:59:59'::timestamp without time zone + '20 days'::interval)))
        )
 SELECT sessions_today.hall,
    sessions_today.film_name,
    sessions_today.datetime AS session_today_time,
    sessions_after_20_days.datetime AS session_after_20_days_time
   FROM (sessions_today
     LEFT JOIN sessions_after_20_days ON (((sessions_today.hall = sessions_after_20_days.hall) AND (sessions_today.film_name = sessions_after_20_days.film_name))))
  ORDER BY sessions_today.datetime;
