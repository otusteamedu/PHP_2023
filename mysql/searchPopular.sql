SELECT
    m.name,
    count(m.id) as count
FROM checkout
    JOIN basket b on checkout.id = b.checkout_id
    JOIN ticket t on t.id = b.ticket_id
    JOIN session s on s.id = t.session_id
    JOIN movie m on m.id = s.movie_id
GROUP BY m.id
ORDER BY count desc
    LIMIT 1