SELECT a.seance_id, c.name, b.date, b.time, MAX(a.price), MIN(a.price)
FROM seance_tikets a
JOIN seances b ON b.id=a.seance_id
JOIN films c ON c.id=b.film_id
WHERE seance_id=1
GROUP BY a.seance_id, c.name, b.date, b.time