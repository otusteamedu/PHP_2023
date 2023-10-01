SELECT films."name", SUM(orders.price) as total FROM films 
INNER JOIN sessions ON sessions.film_id = films.id 
INNER JOIN orders ON orders.session_id = sessions.id
WHERE orders.status = 'purchased'
GROUP BY(films."id")
ORDER BY total DESC
LIMIT 1;