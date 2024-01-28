SELECT m.id, m.name, SUM(t.total)
FROM films m
         JOIN seances s ON m.id = s.film_id
         JOIN (
    SELECT seance_id, SUM(price) AS total
    FROM tickets
             LEFT JOIN orders ON tickets.id = orders.ticket_id
    WHERE orders.ticket_id IS NOT NULL
    GROUP BY seance_id
) t ON s.id = t.seance_id

GROUP BY m.id, m.name
ORDER BY t.total DESC
LIMIT 1;