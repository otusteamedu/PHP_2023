select count(t.id)
from ticket t
     join checkout c on c.id = t.checkout_id
where date(c.date) < current_date and date(c.date) >= current_date - interval '6 day';