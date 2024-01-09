CREATE VIEW "view_marketing" AS
    SELECT f.name AS film_name,
            at.name AS attribute_type,
            a.name AS attribute_name,
            COALESCE(
                   v.value_string,
                   ((v.value_date)::text)::character varying,
                   ((v.value_float)::text)::character varying,
                   ((v.value_int)::text)::character varying,
                   (v.value_text)::character varying,
                   ((v.value_bool)::text)::character varying
            ) AS attribute_value
     FROM ((("values" v
         JOIN films f ON ((f.id = v.film_id)))
         JOIN attributes a ON ((a.id = v.attribute_id)))
         JOIN attribute_types at ON ((at.id = a.type_id)))
     ORDER BY f.name, at.name, a.name;;


CREATE VIEW "view_service" AS
    SELECT f.name AS film_name,
              string_agg((
                             CASE
                                 WHEN (v.value_date = CURRENT_DATE) THEN a.name
                                 ELSE NULL::character varying
                                 END)::text, ', '::text) AS "Today",
              string_agg((
                             CASE
                                 WHEN (v.value_date = (CURRENT_DATE + '20 days'::interval)) THEN a.name
                                 ELSE NULL::character varying
                                 END)::text, ', '::text) AS "+20 days"
       FROM ((films f
           JOIN "values" v ON ((v.film_id = f.id)))
           JOIN attributes a ON ((v.attribute_id = a.id)))
       WHERE ((v.value_date = CURRENT_DATE) OR (v.value_date = (CURRENT_DATE + '20 days'::interval)))
       GROUP BY f.name
       ORDER BY f.name;;
