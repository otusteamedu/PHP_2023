SELECT
    Movies.id AS movie_id,
    Movies.movie_title,
    SUM(Tickets.actual_price) AS total_revenue
FROM
    Movies
        JOIN
    Screenings
    ON
            Movies.id = Screenings.movie_id
        JOIN
    Tickets
    ON
            Screenings.id = Tickets.screening_id
GROUP BY
    Movies.id, Movies.movie_title
ORDER BY
    total_revenue DESC
    LIMIT 1;
