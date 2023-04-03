SELECT SUM("tickets"."amount") as "income", "movies"."name" as "movie"
FROM "tickets"
INNER JOIN "movies" ON "tickets"."movie_id" = "movies"."id"
GROUP BY "movie"
ORDER BY "income" DESC
LIMIT 1
