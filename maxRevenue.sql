SELECT m.name, sum(t.price) as total_revenue
FROM movies m
         INNER JOIN showtime s on m.id = s.movie_id
         INNER JOIN tickets t on s.id = t.showtime_id
GROUP BY m.id
ORDER BY total_revenue DESC
LIMIT 1;
