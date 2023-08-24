select tittle, sum(cost) as amount
from reservations r
         inner join sessions on session_id = sessions.id
         inner join movies on movie_id = movies.id
group by tittle
order by amount desc
limit 1;