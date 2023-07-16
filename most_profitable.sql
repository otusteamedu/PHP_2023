select f.name, sum(s.price) as total
from ticket
         inner join session s on s.id = ticket.session_id
         inner join film f on f.id = s.film_id
group by f.name
order by total desc limit 1;
