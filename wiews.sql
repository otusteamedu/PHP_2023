
CREATE VIEW tasks_relevant_today_and_in_20_days AS
SELECT
    films.name as film_name,
    attributes.name as task_name,
    values.value_date_tz::date as task_date
FROM films, attributes, values
WHERE
--4 - это id типа аттрибутов "служебные даты"
attributes.attr_type_id=4
AND
values.film_id=films.id
AND
values.attr_id=attributes.id
AND
(
	values.value_date_tz::date=CURRENT_DATE
	OR
	values.value_date_tz::date=(CURRENT_DATE + interval '20' day)
);



CREATE VIEW data_for_marketing AS
SELECT
	films.name as film_name,
	attr_types.name as attr_type_name,
	attributes.name as attr_name,
    CASE
           WHEN attr_types.value_column_name = 'value_text' THEN values.value_text
           WHEN attr_types.value_column_name = 'value_bool' THEN values.value_bool::text
           WHEN attr_types.value_column_name = 'value_date' THEN values.value_date::text
		   WHEN attr_types.value_column_name = 'value_date_tz' THEN values.value_date_tz::text
           END value
FROM films, attributes, values, attr_types
WHERE
	attributes.attr_type_id=attr_types.id
	AND
	values.film_id=films.id
	AND
	values.attr_id=attributes.id
