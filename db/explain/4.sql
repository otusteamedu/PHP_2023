explain select m.name, sum(t.price) as total
from ticket as t
join movie m on m.id = t.movie_id
where t.price in (501, 999)
group by m.name
order by total desc
limit 5;
