SELECT film.name, SUM(ticket.price) AS total_revenue
FROM film
         JOIN cinema_sessions ON film.id = cinema_sessions.film_id
         JOIN ticket ON cinema_sessions.id = ticket.session_id
GROUP BY film.name
ORDER BY total_revenue DESC
    LIMIT 1;