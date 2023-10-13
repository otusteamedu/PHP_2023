CREATE VIEW marketing_info AS
	SELECT films."name" as film_name, CONCAT('(', attributestype."name", ')', ' ', "attributes"."name")  as attribute, "values"."value" as "value"  
		FROM "values"
	LEFT JOIN films ON films."id"	= "values".film_id
	LEFT JOIN "attributes" ON "attributes"."id" = "values".attribute_id
	LEFT JOIN "attributestype" ON "attributestype"."id" = "attributes".attribute_type_id;


CREATE VIEW session_schedule AS
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