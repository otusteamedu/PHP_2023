SELECT m.title, SUM(s.price * sc.increase) as total_price
	FROM tickets t 
	JOIN sessions s ON t.session_id = s.id
	JOIN locations l ON t.location_id = l.id
	JOIN seats_categories sc ON l.category_id = sc.id
	JOIN movies m ON s.movie_id = m.id
	GROUP BY m.title
	ORDER BY total_price DESC
	LIMIT 1


