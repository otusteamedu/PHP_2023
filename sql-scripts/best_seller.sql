select
    m.title,
    SUM(t.price)
from ticket t join movie m on m.id = t.movie_id
where t.paid = true
group by m.title
order by SUM(t.price)
desc limit 1;