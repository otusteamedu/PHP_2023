

INSERT INTO movies (title, description, duration,price)
SELECT ( 'Фильм ' || generate_series(1,1000000)), ('Описание фильма ' ||  generate_series(1,1000000)) ,ROUND( 60+RANDOM()*240),(RANDOM()*1000);



INSERT INTO session (datetime, movie_id, hall_id,koef)
SELECT dateSess.datev ,movieSess.movieId ,hallSess.hallId,(0.1+RANDOM())
FROM
    (SELECT (now()::date +  generate_series(-10,989)) AS datev)  as dateSess,
    (SELECT generate_series(1,999), (1+ROUND(RANDOM()*1000000)) AS movieId ) AS movieSess ,
    (SELECT generate_series(1,5), (1+ROUND(RANDOM()*4)) AS hallId ) AS hallSess
;

TRUNCATE TABLE tickets RESTART IDENTITY CASCADE;

INSERT INTO tickets (place_id, session_id)
SELECT places.id, session.id
FROM places, session
WHERE session.hall_id = places.halls_id
  AND RANDOM() < 0.5 LIMIT 1000000;


INSERT INTO orders (pay)
SELECT TRUE AS pay
FROM tickets
WHERE RANDOM() < 0.9;

UPDATE orders
SET pay = false
WHERE (RANDOM() < 0.3);


TRUNCATE TABLE basket_item;
INSERT INTO basket_item (tickets_id, orders_id)
SELECT tickets.id AS tickets_id, orders.id AS orders_id
FROM tickets, orders
WHERE
    (tickets.id  < 300000 AND tickets.id =  orders.id )
   OR
    (tickets.id  > 300000 AND tickets.id < 600000 AND tickets.id =  orders.id + 200000)
   OR
    (tickets.id  > 600000 AND tickets.id =  orders.id + 600000)
ORDER BY orders_id
LIMIT 1000000;
