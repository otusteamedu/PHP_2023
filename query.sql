SELECT
    m.name,
    SUM(t.price) AS sum_price
FROM
    tickets t
    JOIN `sessions` s ON s.id = t.session_id
    JOIN movies m ON m.id = s.movie_id
GROUP BY
    m.name
ORDER BY
    sum_price DESC
LIMIT 1
