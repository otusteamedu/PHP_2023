select sum(t.price) as sum, s.movie_id, m."name" from ticket as t
left join "session" as s on t.session_id = s.id
left join "movie" as m on s.movie_id = m.id
where t.status = 1 and s.start_time between '2020-01-02 00:00:00' and '2020-01-03 00:00:00'
group by s.movie_id, m."name"
order by sum desc
limit 1;