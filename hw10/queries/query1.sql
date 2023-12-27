SELECT M.name
FROM movies M
    INNER JOIN sessions S ON S.movie_id = M.id
WHERE S.start_time >= CURRENT_DATE
 AND S.start_time < CURRENT_DATE + INTERVAL '1 days'
GROUP BY M.name;
