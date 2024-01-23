-- today films
EXPLAIN SELECT films.name FROM films
    LEFT JOIN sessions ON films.id = sessions.film_id
WHERE sessions.time_start::date = CURRENT_DATE::date
GROUP BY films.name;

-- weeek tickets count
EXPLAIN SELECT count(tickets.id) FROM tickets
    LEFT JOIN sessions ON tickets.session_id = sessions.id
WHERE sessions.time_start::date
    BETWEEN (select date_trunc('week', current_date) as current_week_start)
    AND (select date_trunc('week', current_date) + interval '1 week' as current_week_end);

-- afisha
EXPLAIN SELECT films.name, sessions.time_start::time, halls.name, films.film_description
FROM films
    LEFT JOIN sessions ON films.id = sessions.film_id
    LEFT JOIN halls ON halls.id = sessions.hall_id
WHERE sessions.time_start::date = CURRENT_DATE::date
ORDER BY (films.name, sessions.time_start);

-- weeek 3 reacheble films
EXPLAIN SELECT films.name as name, SUM(films.price * COALESCE(zones.coefficient, 1) * COALESCE(halls.coefficient, 1) *
    COALESCE(hall_types.coefficient, 1) * COALESCE(session_types.coefficient, 1)) AS c_price
FROM tickets
         LEFT JOIN sessions ON tickets.session_id = sessions.id
         LEFT JOIN session_types ON sessions.session_type = session_types.id
         LEFT JOIN films ON films.id = sessions.film_id
         LEFT JOIN halls ON halls.id = sessions.hall_id
         LEFT JOIN seats ON seats.id = tickets.seat_id
         LEFT JOIN zones ON seats.zone_id = zones.id
         LEFT JOIN hall_types_halls ON hall_types_halls.hall_id = halls.id
         LEFT JOIN hall_types ON hall_types_halls.hall_id = hall_types.id
WHERE sessions.time_start::date
          BETWEEN (select date_trunc('week', current_date) as current_week_start)
          AND (select date_trunc('week', current_date) + interval '1 week' as current_week_end)
group by films.name
ORDER BY c_price DESC
LIMIT 3;

-- hall scheme for sessions
EXPLAIN SELECT DISTINCT seats.id, tickets.seat_id = seats.id AS seated FROM tickets
    INNER JOIN sessions ON sessions.id = tickets.session_id AND sessions.id = 4010
    LEFT JOIN halls ON halls.id = sessions.hall_id
    LEFT JOIN seats ON seats.hall_id = halls.id
ORDER BY seats.id;

-- max price and min price for session
EXPLAIN WITH session_tickers AS
        (SELECT films.name                                                                   as name,
             films.price * COALESCE(zones.coefficient, 1) * COALESCE(halls.coefficient, 1) *
             COALESCE(hall_types.coefficient, 1) * COALESCE(session_types.coefficient, 1) AS c_price
        FROM tickets
               LEFT JOIN sessions ON tickets.session_id = sessions.id
               LEFT JOIN session_types ON sessions.session_type = session_types.id
               LEFT JOIN films ON films.id = sessions.film_id
               LEFT JOIN halls ON halls.id = sessions.hall_id
               LEFT JOIN seats ON seats.id = tickets.seat_id
               LEFT JOIN zones ON seats.zone_id = zones.id
               LEFT JOIN hall_types_halls ON hall_types_halls.hall_id = halls.id
               LEFT JOIN hall_types ON hall_types_halls.hall_id = hall_types.id
        WHERE sessions.id = 4010)
SELECT max(session_tickers.c_price) AS max_price, min(session_tickers.c_price) AS min_price
from session_tickers;