SELECT f.name AS film_name, SUM(t.price) AS total_revenue
FROM film f
JOIN session s ON f.id = s.film_id
JOIN ticket t ON s.id = t.session_id
GROUP BY f.name
ORDER BY total_revenue DESC
LIMIT 1;
