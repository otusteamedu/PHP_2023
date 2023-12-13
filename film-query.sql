SELECT
    s.film_id,
    f.title as filmname,
    SUM(t.cost) AS total
FROM
    tickets	t
        INNER JOIN sessions s ON s.id = t.session_id
        INNER JOIN films f ON f.id = s.film_id
GROUP BY
    s.film_id, f.title
ORDER BY
    total DESC