
select total_sum, name from (
    SELECT
        sum(t.price) as total_sum, t.hall_id, t.name
    FROM  ticket t
              JOIN client c on c.id = t.client_id
              JOIN seat s2 on s2.id = t.seat_id
              JOIN hall h on h.id = t.hall_id
              LEFT JOIN broadcasting b on b.screening_id = h.screening_id
              LEFT JOIN movie m on m.id = b.movie_id
    GROUP BY t.name
) as tmp ORDER BY tmp.total_sum DESC limit 1;
/*
|total_sum|name                     |
|---------|-------------------------|
|5        |о пользе зарядки по утрам|
*/
