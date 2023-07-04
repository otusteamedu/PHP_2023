SELECT m.title, ts.sale_date
FROM movies m
JOIN ticket_sales ts ON m.id = ts.movie_id
WHERE ts.sale_date = CURRENT_DATE;
