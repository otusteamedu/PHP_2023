SELECT movie.id,
       movie.name,
       SUM(seat_price.price) AS total_cost
FROM movie
         JOIN session ON session.movie_id = movie.id
         JOIN seat_price ON seat_price.session_id = session.id
         JOIN ticket ON ticket.seat_price_id = seat_price.id
WHERE ticket.order_id IS NOT NULL
GROUP BY movie.id
ORDER BY total_cost DESC LIMIT 1;
