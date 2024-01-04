SELECT
    mv.id AS movie_id,
    mv.name AS movie_name,
    SUM(tk.price) AS totalamount
FROM ticket AS tk
LEFT JOIN show AS sh
    ON sh.id = tk.show_id
LEFT JOIN movie AS mv
    ON mv.id = sh.movie_id

GROUP BY mv.id
ORDER BY totalamount DESC

LIMIT 1