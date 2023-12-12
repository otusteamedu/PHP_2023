SELECT sum(o.cost) as "Сборы", concat(m.name, ', ', c.name, ', ', g.name) as "Название фильма" FROM "order" as o
JOIN movie m on m.id = o.movie_id
JOIN country c on c.id = m.country
JOIN genre g on g.id = m.genre
WHERE o.paid = true
GROUP BY m.name, c.name, g.name
ORDER BY sum(o.cost) DESC
limit 1;