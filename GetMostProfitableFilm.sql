SELECT
	Films.id AS MostProfitableFilmId,
	Films.cost*(SELECT COUNT(*) FROM Sessions WHERE Sessions.filmId=Films.id) AS MostProfitableFilmCost
FROM Films, Sessions
ORDER BY MostProfitableFilmCost desc
LIMIT 1;