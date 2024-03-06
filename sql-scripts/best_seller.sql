select
    m.title,
    SUM(o.price)
from "order" o
    join ticket t on t.id = o.ticket_id
    join ticket_price tp on tp.id = t.ticket_price_id
    join session s on t.session_id = s.id
    join movie m on s.movie_id = m.id
where o.is_paid = true
group by m.title
order by SUM(tp.price)
desc limit 1;