CREATE OR REPLACE VIEW public.marketing
AS SELECT
       m.name AS movie,
       ma_p.name AS attr_parent,
       ma.name AS attr,
       at2.name AS type,
       CASE
           WHEN mav.value_string is not null THEN mav.value_string
           WHEN mav.value_bool is not null THEN mav.value_bool::text
           WHEN mav.value_date is not null THEN mav.value_date::text
           WHEN mav.value_float is not null THEN mav.value_float::text
           WHEN mav.value_int is not null THEN mav.value_int::text
        END value
   FROM movie m
            LEFT JOIN movie_attributes_value mav ON mav.movie_id = m.id
            LEFT JOIN movie_attributes ma ON mav.attribute_id = ma.id
            LEFT JOIN movie_attributes ma_p ON ma.parent_id = ma_p.id
            LEFT JOIN attributes_type at2 ON ma.type_id = at2.id
   WHERE mav.active = true
   ORDER BY m.name, ma_p.name, ma.name;
