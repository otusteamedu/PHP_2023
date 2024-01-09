SELECT f.name, sum(p.price) AS price
FROM ticket
     left join public.price p on p.id = ticket.price
     left join public.seance s on s.id = p.seance_id
     left join public.film f on s.film_id = f.id
group by f.name
ORDER BY price DESC
LIMIT 1;
