select chp.row,
       chp.place,
       coalesce(
               (select status
                from session_place
                where session_place.cinema_hall_places_id = chp.id
                  and s.id = session_place.session_id
                limit 1),
               0
           ) as status
from cinema_hall_places chp
         join session s on chp.cinema_hall_id = s.cinema_hall_id
where s.id = (select id from session where id = 1)
  and chp.cinema_hall_id = (select cinema_hall_id from session where id = 1)