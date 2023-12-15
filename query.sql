SELECT
    m.name,
    SUM(t.price) as sum_ticket_prices
FROM tickets t
JOIN seances s ON t.seance_id = s.id
JOIN movies m ON s.movie_id = m.id

GROUP BY m.id
ORDER BY sum_ticket_prices DESC
LIMIT 1;
