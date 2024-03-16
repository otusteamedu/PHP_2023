SELECT movies.title, SUM(tickets.price) AS total
FROM movies
         INNER JOIN sessions ON movies.id = sessions.movie_id
         INNER JOIN tickets ON sessions.id = tickets.sessions_id
         INNER JOIN prices ON tickets.prices_id = prices.id
         INNER JOIN orders ON tickets.id = orders.ticket_id
GROUP BY movies.id
ORDER BY total DESC
LIMIT 1;