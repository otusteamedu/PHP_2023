USE 'cinema_database';

# Нам нужен фильм, на который было продано билетов на наибольшую сумму.
# То есть сумма сумм денег на каждый билет, которая состоит из цены просмотра фильма,
# домноженная на все необходимые коэффициенты.

SELECT f.name AS film_name, SUM(t.price * ht.coefficient * z.coefficient * st.coefficient) AS total_revenue
FROM films f
         JOIN sessions s ON f.film_id = s.film_id
         JOIN tickets t ON s.session_id = t.session_id
         JOIN halls h ON s.hall_id = h.hall_id
         JOIN hall_types_halls hth ON h.hall_id = hth.hall_id
         JOIN hall_types ht ON hth.hall_type_id = ht.hall_type_id
         JOIN seats se ON t.seat_id = se.seat_id
         JOIN zones z ON se.zone_id = z.zone_id
         JOIN session_types st ON s.session_type = st.session_type_id
GROUP BY f.name
ORDER BY total_revenue DESC
LIMIT 1;