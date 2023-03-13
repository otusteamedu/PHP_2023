SELECT f.title, SUM(s.price) as profit
FROM film f
LEFT JOIN db.session s on f.id = s.film_id
LEFT JOIN `order` o on s.id = o.session_id
GROUP BY f.id
ORDER BY profit DESC;