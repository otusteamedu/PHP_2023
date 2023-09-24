SELECT m.id as movie_id, sum(booking.amount) as sum, m.title FROM booking
     LEFT JOIN public.tickets t on t.id = booking.ticket_id
     LEFT JOIN sessions on t.date = sessions.date and t.time = sessions.time and t.hall_id = sessions.hall_id
     LEFT JOIN public.movies m on m.id = sessions.movie_id
group by m.title, m.id
ORDER BY sum DESC  LIMIT 1
