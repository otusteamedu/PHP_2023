SELECT m.title,
       SUM(t.price) as sum
FROM movies as m
    JOIN session s on m.id  = s.movie_id
    JOIN tickets t on s.id = t.session_id
    JOIN basket_item b on t.id = b.tickets_id
    JOIN orders o on b.orders_id = o.id
WHERE o.pay = 1
GROUP BY m.id
ORDER BY sum DESC
    LIMIT 1