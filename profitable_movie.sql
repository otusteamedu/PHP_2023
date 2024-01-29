SELECT films.name, SUM(t.price) AS total_price
FROM films
         JOIN cinema_session cs ON films.id = cs.film_id
         JOIN tickets t ON cs.id = t.cinema_session_id
GROUP BY name
ORDER BY total_price DESC
LIMIT 1;

