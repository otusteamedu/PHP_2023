SELECT S.row, S.number,
       CASE WHEN T.id IS NULL THEN 'не занято' ELSE 'занято' END
FROM seats S
         LEFT JOIN tickets T ON T.seat_id = S.id AND T.session_id = 1
ORDER BY S.row ASC, S.number ASC
