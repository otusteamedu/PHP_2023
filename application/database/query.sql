SELECT films.name, SUM(visitors.price) AS total_money
FROM films
INNER JOIN screenings
        ON screenings.film_id = films.id
INNER JOIN visitors
        ON visitors.screening_id = screenings.id
GROUP BY films.id
ORDER BY total_money DESC
LIMIT 1