select m.id, name, sum(total) from films m
join seances s on m.id = s.film_id
join (select seance_id, sum(price) AS total from tickets t
left join orders o on t.id = o.ticket_id
where o.ticket_id IS NOT NULL
GROUP BY seance_id) t on s.id = t.seance_id
group by id