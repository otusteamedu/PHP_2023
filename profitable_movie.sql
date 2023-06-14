SELECT
    movies.title,
    SUM(ticket.price) AS total_sales
FROM
    movies
        JOIN
    movie_session ON movies.id = movie_session.id
        JOIN
    ticket ON movie_session.id = ticket.movie_session_id
GROUP BY
    movies.title
ORDER BY
    total_sales DESC
    LIMIT 1;