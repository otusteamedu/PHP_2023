SELECT m.id, m.title, SUM(o.price) AS earning FROM orders AS o
LEFT JOIN schedule AS s ON o.schedule_id = s.id
LEFT JOIN moovies AS m ON s.moovie_id = m.id
GROUP BY m.id
ORDER BY earning DESC
LIMIT 1;