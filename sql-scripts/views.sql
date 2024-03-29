CREATE OR REPLACE VIEW movie_main_dates AS
SELECT movie.name, a.name as attribute_name, md.value_date
from movie
         left join movie_data md on movie.id = md.movie_id
         left join attribute a on a.id = md.attribute_id
         left join attribute_type t on t.id = a.type_id
where t.id = 5 AND (md.value_date = CURRENT_DATE or md.value_date = (current_date + interval '20 DAY'));

CREATE OR REPLACE VIEW movie_full_data AS
SELECT
    m.name as movie_name,
    a.name as attribute_name,
    at.name as attribute_type,
    CASE
        WHEN at.type = 'integer'
            THEN md.value_integer::text
        WHEN at.type = 'boolean'
            THEN md.value_boolean::text
        WHEN at.type = 'float'
            THEN md.value_float::text
        WHEN at.type = 'date'
            THEN md.value_date::text
        ELSE md.value_text
        END AS attribute_value
from movie as m,
     attribute as a,
     attribute_type as at,
     movie_data as md
where m.id = md.movie_id and at.id = a.type_id and md.attribute_id = a.id order by m.id;