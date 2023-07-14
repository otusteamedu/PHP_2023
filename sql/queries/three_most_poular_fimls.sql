SELECT film.name AS film_name, SUM(ticket.final_price) AS total_profit
FROM films film
         INNER JOIN tickets ticket ON film.id = ticket.film_id
WHERE ticket.sold_date >= CURRENT_DATE - INTERVAL '7 days'
GROUP BY film.name
ORDER BY total_profit DESC
    LIMIT 3;