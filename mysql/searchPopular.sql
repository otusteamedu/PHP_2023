SELECT
       m.name,
       SUM(t.price) as sum
FROM checkout
    JOIN basket b on checkout.id = b.checkout_id
    JOIN ticket t on t.id = b.ticket_id
    JOIN session s on s.id = t.session_id
    JOIN movie m on m.id = s.movie_id
GROUP BY t.id
ORDER BY sum DESC
LIMIT 1