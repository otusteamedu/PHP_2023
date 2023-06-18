SELECT
    movies.title,
    SUM(sales_ticket.price) AS total_sales
FROM
    movies
        JOIN
    movie_sessions ON movies.id = movie_sessions.id
        JOIN
    sales_ticket ON movie_sessions.id = sales_ticket.movie_sessions_id
GROUP BY
    movies.title
ORDER BY
    total_sales DESC
    LIMIT 1;