SELECT 
	movie_name, 
	date_screen_start, 
	date_screen_end, 
	SUM(place_price) AS all_pay_clients

FROM movies
	INNER JOIN sessions ON (movies.uid = sessions.movie_id)
	INNER JOIN tickets ON (sessions.uid = tickets.session_id)

WHERE
	tickets.available = true
	
GROUP BY
	movie_name,
	date_screen_start, 
	date_screen_end
	
ORDER BY all_pay_clients DESC LIMIT 1		