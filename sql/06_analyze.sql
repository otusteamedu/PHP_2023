/*
 1. Выбор всех фильмов на сегодня.
 */

ANALYSE movies;
EXPLAIN SELECT m.name
FROM movies m
INNER JOIN schedules s on m.id = s.movie_id
WHERE s.datetime >= date_trunc('day', now() at time zone 'Europe/Moscow')
    AND s.datetime <= now();

/*
 2. Подсчёт проданных билетов за неделю.
 */

ANALYSE tickets;
EXPLAIN SELECT count(created_at)
FROM tickets
WHERE created_at >= 1681948800 AND created_at <= 1682553600;

/**
  3. Формирование афиши (фильмы, которые показывают сегодня).
 */

ANALYSE movies;
EXPLAIN SELECT movies.*, string_agg(g.name, ',') as genger
FROM movies
INNER JOIN schedules s on movies.id = s.movie_id
LEFT JOIN movie_genres mg on movies.id = mg.movie_id
LEFT JOIN genres g on g.id = mg.genre_id
WHERE s.datetime >= date_trunc('day', now() at time zone 'Europe/Moscow')
  AND s.datetime <= now()
GROUP BY movies.id;

/*
 4. Поиск 3 самых прибыльных фильмов за неделю.
 */

ANALYSE tickets;
EXPLAIN SELECT m.id, m.name, sum(amount) as amount
FROM tickets
INNER JOIN movies m on m.id = tickets.movie_id
WHERE datetime >= 1681948800 AND datetime <= 1682553600
GROUP BY m.id, m.name
ORDER BY amount DESC
LIMIT 3;

/*
 5. Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс.
 */

ANALYSE places;
EXPLAIN SELECT places.*, case when t.id IS NOT NULL then true else false end as booked
FROM places
INNER JOIN schedules s on places.cinema_hall_id = s.cinema_hall_id
LEFT JOIN tickets t on s.movie_id = t.movie_id and places.id = t.place_id
WHERE s.id = 9;

/*
 6. Вывести диапазон минимальной и максимальной цены за билет на конкретный сеанс.
 */

ANALYSE schedule_prices;
EXPLAIN SELECT min(sp.price) as min_price, max(sp.price) as max_price
FROM schedule_prices sp
WHERE sp.schedule_id = 9;
