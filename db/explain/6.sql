explain
select MIN(price) as min, MAX(price) as max
from session_movie_price
where session_id in (select id from session order by session.movie_id desc limit 5);