/*

Максимально прибыльный фильм

*/

-- Вариант 1
SELECT
    movies.title, SUM(tickets.price) as total
FROM
    movies, tickets, sessions
WHERE
    tickets.session_id = sessions.id
    AND sessions.movie_id = movies.id
    AND tickets.paid_at IS NOT NULL
GROUP BY
    movies.id
ORDER BY
    total DESC
LIMIT 1;

-- Вариант 2
SELECT
    m.title, SUM(t.price) as total
FROM
    movies m
    JOIN sessions s ON s.movie_id = m.id
    JOIN tickets t ON t.session_id = s.id
WHERE
    t.paid_at IS NOT NULL
GROUP BY
    m.id
ORDER BY
    total DESC
LIMIT 1;

-- Вариант 3
WITH total AS (
    SELECT
        sessions.movie_id, SUM(tickets.price) AS total
    FROM
        sessions
    INNER JOIN
        tickets ON tickets.session_id = sessions.id
    WHERE
        tickets.paid_at IS NOT NULL
    GROUP BY
        sessions.movie_id
)
SELECT
    movies.title, total
FROM
    movies
INNER JOIN
    total ON total.movie_id = movies.id
ORDER BY
    total DESC
LIMIT 1;
