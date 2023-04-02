SELECT movie.name, SUM(session_price.price) AS total_price
FROM session
         INNER JOIN movie ON (session.movie_id = movie.id)
         INNER JOIN session_price ON (session_price.session_id = session.id)
         INNER JOIN ticket ON (ticket.session_price_id = session_price.id)
GROUP BY session.movie_id
ORDER BY total_price DESC LIMIT 1;