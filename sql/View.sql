CREATE OR REPLACE VIEW movies_for_marketers AS
SELECT
    m.name as movie_name,
    a.name as attribute_name,
    at.key as attribute_type,
    CASE
        WHEN at.type = 'boolean' THEN mav.value_boolean::varchar
        WHEN at.type = 'int' THEN mav.value_int::varchar
        WHEN at.type = 'float' THEN mav.value_float::varchar
        WHEN at.type = 'string' THEN mav.value_string
        WHEN at.type = 'text' THEN mav.value_text
        WHEN at.type = 'datetime' THEN mav.value_date::varchar
    END as attribute_value
FROM movies as m
INNER JOIN movie_attribute_values mav on m.id = mav.movie_id
INNER JOIN attributes a on mav.attribute_id = a.id
INNER JOIN attribute_types at on a.type_id = at.id
WHERE at.key != 'service_dates';

CREATE OR REPLACE VIEW today_tasks AS
SELECT m.id as movie_id, concat(a.name, ': ', mav.value_date) as task
FROM movies as m
INNER JOIN movie_attribute_values mav on m.id = mav.movie_id
INNER JOIN attributes a on a.id = mav.attribute_id
INNER JOIN attribute_types t on t.id = a.type_id
WHERE mav.value_date::date = CURRENT_DATE
  AND t.key = 'service_dates';

CREATE OR REPLACE VIEW future_20_days_tasks AS
SELECT m.id as movie_id, concat(a.name, ': ', mav.value_date) as task
FROM movies as m
INNER JOIN movie_attribute_values mav on m.id = mav.movie_id
INNER JOIN attributes a on a.id = mav.attribute_id
INNER JOIN attribute_types t on t.id = a.type_id
WHERE mav.value_date::date BETWEEN CURRENT_DATE AND CURRENT_DATE + INTERVAL '20 DAYS'
  AND t.key = 'service_dates';

CREATE OR REPLACE VIEW movie_tasks AS
SELECT m.name, tt.task as today, f20dt.task as futures20days
FROM movies as m
INNER JOIN today_tasks tt on m.id = tt.movie_id
INNER JOIN future_20_days_tasks f20dt on m.id = f20dt.movie_id;
