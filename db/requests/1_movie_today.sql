select m.name, s.start_date, s.end_date
from session s
         join movie m on s.movie_id = m.id
where date(start_date) = current_date;