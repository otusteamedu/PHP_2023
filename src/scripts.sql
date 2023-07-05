-- All movies
EXPLAIN SELECT name FROM movie
    INNER JOIN showtime s on movie.id = s.movie_id
WHERE DATE(s.start_time) = CURRENT_DATE;

-- Tickets sold in a week
EXPLAIN SELECT id FROM ticket
WHERE sale_date BETWEEN CURRENT_DATE - INTERVAL '6 days' AND CURRENT_DATE;

-- Movie poster
EXPLAIN SELECT m.name movie, array_agg(s.start_time) FROM movie m
    INNER JOIN showtime s on m.id = s.movie_id
WHERE DATE(s.start_time) = CURRENT_DATE
GROUP BY m.name;

-- Most profitable movies of the week
EXPLAIN SELECT m.name movie, sum(t.price) total_revenue FROM movie m
    INNER JOIN showtime s on m.id = s.movie_id
    INNER JOIN ticket t on s.id = t.showtime_id
WHERE DATE(s.start_time) BETWEEN CURRENT_DATE - INTERVAL '6 days' AND CURRENT_DATE
GROUP BY m.name
ORDER BY total_revenue DESC
LIMIT 3;

-- Hall schema
EXPLAIN SELECT hr.id row_id, hr.seats, array_agg(t.seat) occupied_seats
FROM hall_row hr
    LEFT JOIN ticket t ON t.showtime_id = 2 AND t.row = hr.id
WHERE hr.hall_id = 3
GROUP BY hr.id, hr.seats;

-- Min and max ticket prices
EXPLAIN SELECT max(t.price), min(t.price) FROM ticket t
    INNER JOIN showtime s on s.id = t.showtime_id
WHERE s.id = 2;

-- Top 15 the biggest objects
SELECT relname AS object_name,
       pg_size_pretty(pg_total_relation_size(oid)) AS total_size
FROM pg_class
WHERE relkind IN ('r', 'i')
  AND relname !~ '^pg_'
ORDER BY pg_total_relation_size(oid) DESC
LIMIT 15;

-- Top 5 the most used indexes. Use ASC if you want top the least used indexes
SELECT indexrelname AS index_name,
       idx_scan AS total_scans
FROM pg_stat_user_indexes
ORDER BY idx_scan DESC
LIMIT 5;
