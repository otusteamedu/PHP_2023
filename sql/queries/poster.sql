SELECT f.name, s.date_start, s.time_start
FROM films f
     JOIN sessions s ON f.id = s.film_id
WHERE s.date_start = CURRENT_DATE;