SELECT S.id, MIN(T.price), MAX(T.price)
FROM sessions S
    INNER JOIN tickets T ON T.session_id = S.id
WHERE S.id = 5
GROUP BY S.id
