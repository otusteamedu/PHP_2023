-- фильмы по прибыльности
SELECT
    f.id as film_id,
    f.name as film_name,
    COUNT(*) as tickets_sold,
    SUM(tt.price) as sum
FROM films f
    INNER JOIN sessions s on f.id = s.film_id
    INNER JOIN tickets t on t.session_id = s.id
    INNER JOIN tickets_types tt on tt.id = t.type
GROUP BY f.id
ORDER BY sum DESC;

-- Самый прибыльный фильм
SELECT
    f.id as film_id,
    f.name as film_name,
    COUNT(*) as tickets_sold,
    SUM(tt.price) as sum
FROM films f
         INNER JOIN sessions s on f.id = s.film_id
         INNER JOIN tickets t on t.session_id = s.id
         INNER JOIN tickets_types tt on tt.id = t.type
GROUP BY f.id
ORDER BY sum DESC
LIMIT 1;

-- Самый посещаемый фильм
SELECT
    f.id as film_id,
    f.name as film_name,
    COUNT(*) as tickets_sold,
    SUM(tt.price) as sum
FROM films f
         INNER JOIN sessions s on f.id = s.film_id
         INNER JOIN tickets t on t.session_id = s.id
         INNER JOIN tickets_types tt on tt.id = t.type
GROUP BY f.id
ORDER BY tickets_sold DESC
LIMIT 1;

-- Самый продаваемый за период
SELECT
    f.id as film_id,
    f.name as film_name,
    COUNT(*) as tickets_sold,
    SUM(tt.price) as sum
FROM films f
         INNER JOIN sessions s on f.id = s.film_id
         INNER JOIN tickets t on t.session_id = s.id
         INNER JOIN tickets_types tt on tt.id = t.type
WHERE date >= '2000-03-25' AND date <= '2000-03-26'
GROUP BY f.id
ORDER BY tickets_sold DESC
LIMIT 1;