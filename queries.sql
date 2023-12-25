-- Query to retrieve all movies released after a certain date:

EXPLAIN SELECT name, release_date FROM movies WHERE release_date > '2020-01-01';
CREATE INDEX idx_movies_name_release_date ON movies(name, release_date);


-- A query to count the total number of movies:

EXPLAIN SELECT COUNT(*) FROM movies;

-- Query to retrieve a list of movies of a specific duration:


EXPLAIN SELECT name, duration FROM movies WHERE duration >= 120;


-- Query to find the average duration of movies for each attribute type:

EXPLAIN SELECT at.type_name, AVG(m.duration) AS average_duration
FROM movies m
         JOIN attribute_values av ON m.movie_id = av.movie_id
         JOIN attributes a ON av.attribute_id = a.attribute_id
         JOIN attribute_types at ON a.type_id = at.type_id
GROUP BY at.type_name;


-- Query to retrieve a list of movies with the number of related attributes:

EXPLAIN  SELECT m.name, COUNT(av.attribute_id) AS attribute_count
FROM movies m
         JOIN attribute_values av ON m.movie_id = av.movie_id
GROUP BY m.name;

-- Query to retrieve a list of movies that have a certain attribute (e.g. 'oscar'):

EXPLAIN SELECT m.name, a.name AS attribute_name
FROM movies m
         JOIN attribute_values av ON m.movie_id = av.movie_id
         JOIN attributes a ON av.attribute_id = a.attribute_id
WHERE a.name = 'Оскар';