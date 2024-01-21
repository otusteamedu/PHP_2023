SELECT a.seance_id, c.name, b.date, b.time, sum(a.price) as seance_profit
FROM seance_tikets a
JOIN seances b ON b.id=a.seance_id
JOIN films c ON c.id=b.film_id
WHERE b.date>='2023-12-01' and b.date<='2023-12-07'
GROUP BY a.seance_id, c.name, b.date, b.time
ORDER BY seance_profit
DESC LIMIT 3