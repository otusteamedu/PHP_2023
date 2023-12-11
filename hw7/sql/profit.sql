SELECT M.name, SUM(T.price) as profit
FROM movies M
         INNER JOIN shedule S ON S.movie_id = M.id
         LEFT JOIN tickets T ON T.shedule_id = S.id
GROUP BY M.id
ORDER BY profit DESC
    LIMIT 1
