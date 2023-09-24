SELECT s.name, SUM(t.amount) AS total_profit
FROM sessions s
         INNER JOIN hall_sessions hs on s.id = hs.session_id
         INNER JOIN places p on hs.id = p.hall_session_id
         INNER JOIN transactions t ON t.place_id = p.id
GROUP BY s.name
ORDER BY total_profit DESC
    LIMIT 1;
