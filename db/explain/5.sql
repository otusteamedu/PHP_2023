explain
select ch.name, m.name, s.start_date, smp.price
from cinema_hall as ch
         join session s on ch.id = s.cinema_hall_id
         join session_movie_price smp on s.id = smp.session_id
         join movie m on smp.movie_id = m.id
where s.start_date in ('2023-07-10', '2023-07-16')
order by s.start_date
