SELECT M.name, SUM(T.price) as profit
FROM movies M
         INNER JOIN sessions S ON S.movie_id = M.id
         INNER JOIN tickets T ON T.session_id = S.id
GROUP BY M.id
ORDER BY profit DESC
    LIMIT 1
