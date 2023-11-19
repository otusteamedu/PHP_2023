CREATE OR REPLACE VIEW marketing_info AS
	SELECT films."name" as film_name, CONCAT('(', attributes."type", ')', ' ', "attributes"."name")  as attribute,
	CASE
		 WHEN attributevalues.int_value IS NOT NULL THEN attributevalues.int_value::text
		 WHEN attributevalues.string_value IS NOT NULL THEN attributevalues.string_value::text
		 WHEN attributevalues.text_value IS NOT NULL THEN attributevalues.text_value::text
		 WHEN attributevalues.float_value IS NOT NULL THEN attributevalues.float_value::text
		 WHEN attributevalues.datetime_value IS NOT NULL THEN attributevalues.datetime_value::text
		 WHEN attributevalues.date_value IS NOT NULL THEN attributevalues.date_value::text
		 WHEN attributevalues.bool_value IS NOT NULL THEN attributevalues.bool_value::text
		 END as value
	FROM "attributevalues"
LEFT JOIN films ON films."id"	= "attributevalues".film_id
LEFT JOIN "attributes" ON "attributes"."id" = attributevalues.attribute_id;


CREATE OR REPLACE VIEW session_schedule AS
WITH films_today AS
	(SELECT halls.name as "hall", films.name as "film", sessions.start_at as "today_time" FROM sessions 
	LEFT JOIN films ON films."id" = sessions.film_id
	LEFT JOIN halls ON halls."id" = sessions.hall_id
	WHERE start_at > "timestamp"('2023-10-12 00:00:00') and start_at < "timestamp"('2023-10-12 23:59:59')),
		films_next AS 
	(SELECT halls.name as "hall", films.name as "film", sessions.start_at as "next_time" FROM sessions 
	LEFT JOIN films ON films."id" = sessions.film_id
	LEFT JOIN halls ON halls."id" = sessions.hall_id
	WHERE start_at > "timestamp"('2023-10-12 00:00:00') + INTERVAL '20 day'  and start_at < "timestamp"('2023-10-12 23:59:59') + INTERVAL '20 day')
	SELECT films_today.hall, films_today.film, films_today.today_time, films_next.next_time FROM films_today
	LEFT JOIN films_next ON films_next.hall = films_today.hall AND films_next.film = films_today.film
	ORDER BY(today_time);