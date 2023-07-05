
SELECT
	SUM(soldTickets.cost) MostProfitableFilmCost,
	Films.id
FROM soldTickets, Films, Sessions
WHERE soldTickets.sessionId=Sessions.id AND Sessions.filmId=Films.id
GROUP BY Films.id
ORDER BY MostProfitableFilmCost desc
LIMIT 1;