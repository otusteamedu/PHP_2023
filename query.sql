SELECT "s"."movie_id",SUM("price") AS total_sum FROM "ticket" AS "t" 
LEFT JOIN "session" AS "s" ON "t"."session_id" = "s"."id"
WHERE "t"."confirmed" 
GROUP BY "s"."movie_id" 
ORDER BY "total_sum" DESC LIMIT 1;