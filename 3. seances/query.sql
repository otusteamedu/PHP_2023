SELECT
	f.ID, f.NAME, h.NAME AS hall_name,s.DATE, s.TIME 
FROM
	films AS f
	JOIN seances AS s ON s.film_id = f.
	ID JOIN halls AS h ON h.ID = s.hall_id 
WHERE
	s.DATE = '2023-12-03' 
ORDER BY
	s.TIME