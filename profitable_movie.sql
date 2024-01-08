SELECT m.title, sum(total_price) as total
    FROM tickets t
    JOIN sessions s ON t.session_id = s.id
    JOIN movies m ON s.movie_id = m.id
    GROUP BY m.title
    ORDER BY total DESC
    LIMIT 1


