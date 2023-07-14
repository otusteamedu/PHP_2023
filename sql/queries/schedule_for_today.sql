SELECT sessions.id, films.name AS film_name, halls.number AS hall_number, sessions.time_start
FROM sessions
     JOIN films ON films.id = sessions.film_id
     JOIN halls ON halls.id = sessions.hall_id
WHERE sessions.date_start = CURRENT_DATE;