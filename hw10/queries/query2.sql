SELECT COUNT(T.*)
FROM tickets T
         INNER JOIN sessions S ON S.id = T.session_id
WHERE S.start_time >= CURRENT_DATE AND S.start_time < CURRENT_DATE + INTERVAL '7 days';
