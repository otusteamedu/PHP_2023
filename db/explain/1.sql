explain
select session_id
from ticket
where price in (350, 500)
order by id desc;
