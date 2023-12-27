SELECT M.name, S.start_time, H.name
FROM sessions S
         INNER JOIN movies M ON M.id = S.movie_id
         INNER JOIN halls H ON H.id = S.hall_id
WHERE S.start_time >= CURRENT_DATE
  AND S.start_time < CURRENT_DATE + INTERVAL '1 days'
ORDER BY S.movie_id ASC, S.start_time ASC, S.hall_id ASC;
