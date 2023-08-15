select m."name", s.start_time, h."name", min(t.price) as price_min, max(t.price) as price_max from ticket t
left join "session" s ON t.session_id=s.id
left join movie m on s.movie_id = m.id
left join hall h  on s.hall_id = h.id
where t.session_id ='b72d9e8e-27af-4851-8a12-0f59a41d261a'
group by m."name", s.start_time, h."name"
