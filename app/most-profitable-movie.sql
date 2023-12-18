SELECT name
FROM movie
     INNER JOIN session s
                ON movie.id = s.movie_id
     INNER JOIN ticket t
                ON s.id = t.session_id
GROUP BY name
ORDER BY sum(t.amount) DESC
LIMIT 1;