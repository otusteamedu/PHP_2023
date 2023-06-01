SELECT sum(t.price) AS sum, s.film_id, f.title
FROM tickets AS t
JOIN sessions AS s ON(t.session_id = s.film_id)
JOIN films AS f ON(f.id = s.id)
GROUP BY s.film_id, f.title 
ORDER BY sum DESC LIMIT 1;