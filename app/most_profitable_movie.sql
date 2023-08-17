select m.name, sum(o.price)
from movies m
         inner join sessions s on m.id = s.movie_id
         inner join orders o on s.id = o.session_id
group by m.name
order by 2 desc
limit 1;
