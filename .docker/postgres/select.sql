SELECT
    tickets.name,
    tickets.sum as total_sum
FROM (
    SELECT movies.name, SUM(places.price + movies.price) as sum
    FROM tickets
        INNER JOIN places ON tickets.place_id = places.place_id AND tickets.hall_id = places.hall_id
        INNER JOIN sessions ON tickets.session_id = sessions.id
        INNER JOIN movies ON sessions.movie_id = movies.id
    WHERE tickets.id IN (SELECT ticket_id FROM clients_tickets)
    GROUP BY movies.id
) as tickets
ORDER BY total_sum DESC;