SELECT SUM(s.price) AS MAX_PROFIT, CONCAT(CONCAT_WS(' (', m.title, m.year), ')') AS MOVIE
FROM tickets t
LEFT JOIN sessions s ON s.id=t.session_id
LEFT JOIN movies m ON m.id=s.movie_id
WHERE t.status='Completed'
GROUP BY s.movie_id
ORDER BY SUM(s.price) DESC
LIMIT 1
