SELECT
    m.name,
    SUM(sp.price)

FROM sold_ticket st
INNER JOIN schedule sch ON sch.id=st.schedule_id
INNER JOIN movie m ON m.id=sch.movie_id
INNER JOIN seat_price sp ON sp.id=st.seat_id

GROUP BY m.id
ORDER BY SUM(sp.price) DESC
LIMIT 1;