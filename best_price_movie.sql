SELECT m.title AS movie_title,
       m.duration AS movie_duration,
       m.rating AS movie_rating,
       t.price AS ticket_price,
       s.start_time AS session_start_time
FROM cinema.tickets t
         INNER JOIN sessions s on t.session_id = s.id
         INNER JOIN rooms r on s.room_id = r.id
         INNER JOIN movies m on s.movie_id = m.id
WHERE s.start_time > (now() + INTERVAL 1 HOUR)
ORDER BY t.price
LIMIT 1;