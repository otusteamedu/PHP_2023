select m.name, sum(t.price) as sum
from ticket t
         join checkout c on c.id = t.checkout_id
         join session s on s.id = t.session_id
         join movie m on s.movie_id = m.id
where date(c.date) < current_date
  and date(c.date) >= current_date - interval '6 day'
group by m.name
order by sum desc
limit 3;
