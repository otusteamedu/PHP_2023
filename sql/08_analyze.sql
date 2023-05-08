/*
 2. Подсчёт проданных билетов за неделю.
 */

ANALYSE film_box_office;
EXPLAIN SELECT sum(tickets_count)
FROM film_box_office
WHERE day >= '2023-04-20' AND day <= '2023-04-27';

/*
 4. Поиск 3 самых прибыльных фильмов за неделю.
 */

ANALYSE film_box_office;
EXPLAIN SELECT movie_id, m.name, sum(amount) as amount
FROM film_box_office fbo
INNER JOIN movies m on m.id = fbo.movie_id
WHERE day >= '2023-04-20' AND day <= '2023-04-27'
GROUP BY movie_id, m.name
ORDER BY amount DESC
LIMIT 3;
