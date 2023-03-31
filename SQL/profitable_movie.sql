SELECT
    m.movie_id,
    m.title,
    SUM(s.ticket_price) AS total_revenue
FROM
    Tickets t
        JOIN Screenings s ON t.screening_id = s.screening_id
        JOIN Movies m ON s.movie_id = m.movie_id
GROUP BY
    m.movie_id,
    m.title
ORDER BY
    total_revenue DESC
    LIMIT 1;