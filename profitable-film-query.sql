SELECT
	B.NAME as film,
	SUM ( C.price ) AS max_price 
FROM
	seances	A 
	INNER JOIN films B ON B.ID = A.film_id
	LEFT JOIN seance_tikets C ON C.seance_id = A.ID 
GROUP BY
	b.NAME 
ORDER BY
	max_price DESC