-- Очистка существующей структуры данных
DROP INDEX IF EXISTS idx_values_movie_id;
DROP INDEX IF EXISTS idx_values_attribute_id;
DROP VIEW IF EXISTS view_tasks;
DROP VIEW IF EXISTS view_marketing_data;
DROP TABLE IF EXISTS attributevalues;
DROP TABLE IF EXISTS attributes;
DROP TABLE IF EXISTS attributetypes;
DROP TABLE IF EXISTS movies;

-- Создание таблиц

CREATE TABLE movies (
    id SERIAL PRIMARY KEY,
    name VARCHAR(128)
);

CREATE TABLE attributetypes (
    id SERIAL PRIMARY KEY,
    name VARCHAR(8)
);

CREATE TABLE attributes (
    id SERIAL PRIMARY KEY,
  	type_id INT,
    name VARCHAR(32),
    FOREIGN KEY (type_id) REFERENCES attributetypes(id)
);

CREATE TABLE attributevalues (
    id SERIAL PRIMARY KEY,
    movie_id INT,
    attribute_id INT,
    value_str VARCHAR(512),
    value_txt TEXT,
    value_int INT,
    value_dbl DOUBLE PRECISION,
    value_dte DATE,
    value_bln BOOLEAN,
    FOREIGN KEY (movie_id) REFERENCES movies(id),    
    FOREIGN KEY (attribute_id) REFERENCES attributes(id)    
);

-- Создание индексов

CREATE INDEX idx_values_movie_id ON attributevalues(movie_id);
CREATE INDEX idx_values_attribute_id ON attributevalues(attribute_id);

-- Создание View

CREATE VIEW view_tasks AS
SELECT 
    mv.name AS movie_name,
    at.name AS today_task_name,
    at20.name AS day20_task_name
FROM 
    attributevalues av
LEFT JOIN movies mv 
    ON mv.id = av.movie_id
LEFT JOIN attributes at 
    ON at.id = av.attribute_id
LEFT JOIN attributevalues av20 
    ON av20.movie_id = av.movie_id
    AND av20.value_dte = CURRENT_DATE + INTERVAL '20 days'
    AND av20.attribute_id IN (7,8)
LEFT JOIN attributes at20 
    ON at20.id = av20.attribute_id
WHERE 
    av.value_dte = CURRENT_DATE 
    AND av.attribute_id IN (7,8);


CREATE VIEW view_marketing_data AS
SELECT
    mv.name AS movie_name,
    at.name AS type,
    a.name AS attribute,
    CASE 
        WHEN a.type_id = 1 THEN av.value_str::TEXT
        WHEN a.type_id = 2 THEN av.value_txt
        WHEN a.type_id = 3 THEN av.value_int::TEXT
        WHEN a.type_id = 4 THEN ROUND(CAST(av.value_dbl AS NUMERIC),2)::TEXT
        WHEN a.type_id = 5 THEN av.value_dte::TEXT
        WHEN a.type_id = 6 THEN av.value_bln::TEXT
        ELSE NULL
    END AS value

FROM 
    attributevalues av
LEFT JOIN movies mv
    ON mv.id = av.movie_id
LEFT JOIN attributes a
    ON a.id = av.attribute_id
LEFT JOIN attributetypes at
    ON at.id = a.type_id
ORDER BY 
    av.movie_id, at.id;