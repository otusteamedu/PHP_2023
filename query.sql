SELECT
    m.name,
    SUM(t.price) AS sum_price
FROM
    ticket t
    JOIN `session` s ON s.id = t.session_id
    JOIN movie m ON m.id = s.movie_id
GROUP BY
    m.name
ORDER BY
    sum_price DESC
LIMIT 1
