SELECT SUM(price) as summ, f.name as name
from ticket t
         LEFT JOIN session s on t.session = s.id
         LEFT JOIN film f on s.film = f.id
         LEFT JOIN seat st on st.price = t.seat
group by f.id
ORDER BY summ DESC
LIMIT 1;