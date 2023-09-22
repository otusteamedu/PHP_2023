SELECT f.name, SUM(p.price) FROM tickets t
     INNER JOIN
 rows_seats_categories rsc ON t.rows_seats_categories_id = rsc.id
     INNER JOIN
 sessions s ON t.session_id = s.id
     INNER JOIN
 films f ON s.film_id = f.id
     INNER JOIN
 prices p ON p.session_id = s.id
WHERE t.status LIKE 'booked' AND p.seat_category_id = rsc.seat_category_id
GROUP BY f.id
ORDER by SUM(p.price) DESC;