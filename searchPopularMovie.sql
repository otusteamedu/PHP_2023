SELECT m.title as "Фильм",
       FLOOR( SUM(m.price * s.koef * p.koef * h.koef)) as sum,
  FLOOR(AVG(m.price * s.koef * p.koef * h.koef)) as "Cредняя\nцена билета"
FROM movies as m
    JOIN session s on m.id  = s.movie_id
    JOIN tickets t on s.id = t.session_id
    JOIN basket_item b on t.id = b.tickets_id
    JOIN places p on t.place_id = p.id
    JOIN orders o on b.orders_id = o.id
    JOIN halls h on s.hall_id = h.id
WHERE o.pay = 1
GROUP BY m.id
ORDER BY sum DESC
    LIMIT 1