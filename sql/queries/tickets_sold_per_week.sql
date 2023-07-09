SELECT COUNT(*) AS ticket_count
FROM tickets
     JOIN session_place_price ON tickets.session_place_price_id = session_place_price.id
     JOIN sessions ON session_place_price.session_id = sessions.id
WHERE sessions.date_start >= CURRENT_DATE - INTERVAL '7 days';