SELECT
	movies.title,
	SUM(tickets.price) AS movie_sum
FROM
	movies
JOIN seances ON
	movies.movie_id = seances.movie_id
JOIN tickets ON
	seances.seance_id = tickets.seance_id
WHERE tickets.payment_flag = TRUE
GROUP BY
	movies.title
ORDER BY
	movie_sum desc
LIMIT 1;
