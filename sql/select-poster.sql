select distinct m.id as id, m."name"  from "session" AS s
left join movie as m on s.movie_id=m.id
where DATE(s.start_time) = CURRENT_DATE