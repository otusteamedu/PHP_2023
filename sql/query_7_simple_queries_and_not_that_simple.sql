-- Простые запросы (задействована только 1 таблица)

-- 1. Выбор всех фильмов
SELECT * FROM movies;

-- 2. Подсчет количества фильмов
SELECT COUNT(*) FROM movies;

-- 3. Поиск фильма по ID
SELECT * FROM movies WHERE id = <movie_id>;

-- Сложные запросы (агрегатные функции, связи таблиц)

-- 4. Подсчет средней продолжительности фильмов
-- Сложный запрос: Подсчет средней длительности фильмов
SELECT AVG(float_value) AS average_duration
FROM values v
JOIN attributes a ON v.attribute_id = a.id
JOIN attribute_types at ON v.attribute_type_id = at.id
JOIN movies m ON v.movie_id = m.id
WHERE a.name = 'duration' AND at.name = 'float';


-- 5. Подсчет общего количества проданных билетов для каждого фильма
SELECT m.title, SUM(ts.quantity) AS total_tickets_sold
FROM movies m
JOIN ticket_sales ts ON m.id = ts.movie_id
GROUP BY m.title;

-- 6. Поиск фильма с наибольшим количеством проданных билетов
SELECT m.title, SUM(ts.quantity) AS total_tickets_sold
FROM movies m
JOIN ticket_sales ts ON m.id = ts.movie_id
GROUP BY m.title
ORDER BY total_tickets_sold DESC
LIMIT 1;
