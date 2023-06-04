SELECT
  Movies.movie_title,
  SUM(Tickets.price) AS total_sales
FROM
  Movies
JOIN
  Screenings ON Movies.movie_id = Screenings.movie_id
JOIN
  Tickets ON Screenings.screening_id = Tickets.screening_id
GROUP BY
  Movies.movie_title
ORDER BY
  total_sales DESC
LIMIT 1;
