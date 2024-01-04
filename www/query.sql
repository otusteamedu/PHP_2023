SELECT
    m.id AS movie_id,
    m.name AS movie_name,
    SUM(sp.price) AS total_revenue
FROM
    movies m
        JOIN sessions s ON m.id = s.movie_id
        JOIN session_price sp ON s.id = sp.session_id
        JOIN tickets t ON s.id = t.session_id
WHERE
    t.status = 'sold'
GROUP BY
    m.id, m.name
ORDER BY
    total_revenue DESC
    LIMIT 1;