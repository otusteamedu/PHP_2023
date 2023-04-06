SELECT movie.name, SUM(price.value) AS total_price
FROM SESSION
         INNER JOIN movie ON (session.movie_id = movie.id)
         INNER JOIN session_price ON (session_price.session_id = session.id)
         INNER JOIN price ON (price.id = session_price.price_id)
GROUP BY session.movie_id
ORDER BY total_price DESC LIMIT 1;