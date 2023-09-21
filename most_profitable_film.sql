SELECT f.name, sum(t.price) FROM tickets t
LEFT JOIN 
	sessions s ON t.session_id = s.id
LEFT JOIN
	films f ON s.film_id = f.id
WHERE t.status LIKE 'booked'
GROUP BY f.id
ORDER BY sum(t.price) DESC;