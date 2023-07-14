SELECT COUNT(id) AS ticket_count
FROM tickets WHERE tickets.sold_date >= CURRENT_DATE - INTERVAL '7 days' AND sold_date < CURRENT_DATE;