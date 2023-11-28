select
	sum(t.price) as total_sum,
	f.title
from
	tickets t
join seances s on
	t.seance_id = s.id
join films f on
	s.film_id = f.id
where
	status = 'paid'
GROUP by
	f.title
order by
	total_sum desc
LIMIT 1