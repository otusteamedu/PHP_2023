SELECT ID, NAME 
FROM
	films 
WHERE
	ID IN (
	SELECT film_id 
	FROM seances 
	WHERE date_unix_ts = extract(epoch from '2023-12-03'::date)
)