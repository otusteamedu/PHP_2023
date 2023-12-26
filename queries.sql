-- Query to retrieve all movies released after a certain date:

EXPLAIN ANALYSE SELECT name FROM movies WHERE year > 2020 OR (year = 2020 AND month > 1) OR (year = 2020 AND month = 1 AND day > 1);


CREATE INDEX idx_movies_day ON movies(day);
CREATE INDEX idx_movies_month ON movies(month);
CREATE INDEX idx_movies_year ON movies(year);

CREATE INDEX idx_release_year ON movies ((EXTRACT(YEAR FROM release_date)));


CREATE INDEX idx_brin_release_date ON movies USING BRIN (release_date);
DROP INDEX idx_brin_release_date;

CREATE INDEX idx_movies_release_date ON movies(release_date);
DROP INDEX idx_movies_release_date;

ANALYSE movies;


select count(*) from attribute_types;
select count(*) from attribute_values;
select count(*) from attributes;
select count(*) from movies;


-- A query to count the total number of movies:

EXPLAIN analyse SELECT COUNT(movie_id) FROM movies;

-- Query to retrieve a list of movies of a specific duration:


EXPLAIN ANALYSE SELECT name, duration FROM movies WHERE duration >= 120;
CREATE INDEX idx_movies_duration ON movies(duration);
DROP INDEX idx_movies_duration;
analyse movies;




-- Query to find the average duration of movies for each attribute type:

EXPLAIN SELECT at.type_name, AVG(m.duration) AS average_duration
FROM movies m
         JOIN attribute_values av ON m.movie_id = av.movie_id
         JOIN attributes a ON av.attribute_id = a.attribute_id
         JOIN attribute_types at ON a.type_id = at.type_id
GROUP BY at.type_name;

CREATE INDEX idx_movies_movie_id ON movies(movie_id);
CREATE INDEX idx_attribute_values_movie_id ON attribute_values(movie_id);
CREATE INDEX idx_attribute_values_attribute_id ON attribute_values(attribute_id);
CREATE INDEX idx_attributes_attribute_id ON attributes(attribute_id);
CREATE INDEX idx_attributes_type_id ON attributes(type_id);
CREATE INDEX idx_attribute_types_type_id ON attribute_types(type_id);

DROP INDEX idx_movies_movie_id;
DROP INDEX idx_attribute_values_movie_id;
DROP INDEX idx_attribute_values_attribute_id;
DROP INDEX idx_attributes_attribute_id;
DROP INDEX idx_attributes_type_id;
DROP INDEX idx_attribute_types_type_id;

ANALYZE movies;
ANALYZE attribute_values;
ANALYZE attributes;
ANALYZE attribute_types;





ANALYZE movies;
ANALYZE attribute_values;
ANALYZE attributes;
ANALYZE attribute_types;

-- Query to retrieve a list of movies with the number of related attributes:

EXPLAIN  SELECT m.name, COUNT(av.attribute_id) AS attribute_count
FROM movies m
         JOIN attribute_values av ON m.movie_id = av.movie_id
GROUP BY m.name;

CREATE INDEX idx_movies_movie_id ON movies(movie_id);
CREATE INDEX idx_attribute_values_movie_id ON attribute_values(movie_id);

ANALYZE movies;
ANALYZE attribute_values;



DROP INDEX idx_movies_name ;
DROP INDEX idx_attribute_values_movie_id ;

ANALYZE movies;
ANALYZE attribute_values;


-- Query to retrieve a list of movies that have a certain attribute (e.g. 'oscar'):

EXPLAIN SELECT m.name, a.name AS attribute_name
FROM movies m
         JOIN attribute_values av ON m.movie_id = av.movie_id
         JOIN attributes a ON av.attribute_id = a.attribute_id
WHERE a.name = 'Оскар';

ANALYZE attribute_values;
ANALYZE attributes;
ANALYZE movies;


CREATE INDEX idx_attribute_values_movie_id ON attribute_values(movie_id);
CREATE INDEX idx_attributes_attribute_id ON attributes(attribute_id);
CREATE INDEX idx_attributes_name ON attributes(name);


CREATE INDEX idx_movies_name ON movies(name);


CREATE INDEX idx_attribute_values_movie_id ON attribute_values(movie_id);
CREATE INDEX idx_attribute_values_attribute_id ON attribute_values(attribute_id);
CREATE INDEX idx_attributes_name ON attributes(name);

ANALYZE movies;
ANALYZE attribute_values;
ANALYZE attributes;

