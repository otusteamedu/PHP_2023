SELECT m.name, sum(s.price) as total_revenue
FROM movie m
    INNER JOIN session s on m.id = s.movie_id
    INNER JOIN ticket t on s.id = t.session_id
GROUP BY m.id, s.id
ORDER BY total_revenue DESC
LIMIT 1;
