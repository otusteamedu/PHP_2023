select m.name, s.start_date, s.end_date, ch.name
from session s
     join movie m on m.id = s.movie_id
     join cinema_hall ch on s.cinema_hall_id = ch.id
where date(s.start_date) = current_date
order by s.start_date;