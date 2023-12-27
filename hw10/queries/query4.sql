SELECT M.name, SUM(S.price)
FROM movies M
         INNER JOIN sessions S ON S.movie_id = M.id
         INNER JOIN tickets T ON T.session_id = S.id
WHERE S.start_time >= CURRENT_DATE AND S.start_time < CURRENT_DATE + INTERVAL '7 days'
GROUP BY M.id
ORDER BY SUM(S.price) DESC
LIMIT 3;
