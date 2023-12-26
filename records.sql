/*
 10k records
 */
------------------------------------------------------------------------------------------------------------
--
-- Заполнение таблицы attribute_types
INSERT INTO attribute_types (type_name)
SELECT 'Type ' || i
FROM generate_series(1, 3000) as s(i);

-- Заполнение таблицы attributes
-- 7000 строк с именем 'Оскар' и 3000 других имен
INSERT INTO attributes (type_id, name, data_type)
SELECT
    (random() * 2999 + 1)::int, -- Случайное соответствие type_id
        CASE
            WHEN i <= 7000 THEN 'Оскар'
            ELSE 'Attribute ' || i
            END,
    CASE
        WHEN i % 4 = 0 THEN 'text'
        WHEN i % 4 = 1 THEN 'float'
        WHEN i % 4 = 2 THEN 'int'
        WHEN i % 4 = 3 THEN 'date'
        END
FROM generate_series(1, 10000) as s(i);

-- Заполнение таблицы movies
-- Insert data into movies with separate day, month, and year
INSERT INTO movies (name, description, day, month, year, duration)
SELECT
    'Movie ' || s.i,
    'Description for movie ' || s.i,
    EXTRACT(DAY FROM CURRENT_DATE - (s.i % 3650 || ' days')::interval)::INT,
    EXTRACT(MONTH FROM CURRENT_DATE - (s.i % 3650 || ' days')::interval)::INT,
    EXTRACT(YEAR FROM CURRENT_DATE - (s.i % 3650 || ' days')::interval)::INT,
    (random() * 180 + 90)::int
FROM generate_series(1, 10000) as s(i);

-- Заполнение таблицы attribute_values
INSERT INTO attribute_values (movie_id, attribute_id, text_value, float_value, int_value, date_value, json_value)
SELECT
    (random() * 9999 + 1)::int, -- Случайный movie_id
    attribute_id, -- Последовательный attribute_id
    CASE WHEN data_type = 'text' THEN 'Text value for attribute ' || attribute_id ELSE NULL END,
    CASE WHEN data_type = 'float' THEN (random() * 100)::float ELSE NULL END,
    CASE WHEN data_type = 'int' THEN (random() * 100)::int ELSE NULL END,
    CASE WHEN data_type = 'date' THEN CURRENT_DATE - (attribute_id % 3650 || ' days')::interval ELSE NULL END,
    CASE WHEN data_type = 'text' THEN jsonb_build_object('key', 'value') ELSE NULL END
FROM attributes;

/*
 10M records
 */
------------------------------------------------------------------------------------------------------------
-- Заполнение таблицы attribute_types
INSERT INTO attribute_types (type_name)
SELECT 'Type ' || i
FROM generate_series(1, 3000) as s(i);

-- Заполнение таблицы attributes
-- 7000000 строк с именем 'Оскар' и 3000000 других имен
INSERT INTO attributes (type_id, name, data_type)
SELECT
    (random() * 2999 + 1)::int, -- Случайное соответствие type_id
    CASE
        WHEN i <= 7000000 THEN 'Оскар'
        ELSE 'Attribute ' || i
        END,
    CASE
        WHEN i % 4 = 0 THEN 'text'
        WHEN i % 4 = 1 THEN 'float'
        WHEN i % 4 = 2 THEN 'int'
        WHEN i % 4 = 3 THEN 'date'
        END
FROM generate_series(1, 10000000) as s(i);

-- Insert data into movies with separate day, month, and year
INSERT INTO movies (name, description, day, month, year, duration)
SELECT
    'Movie ' || s.i,
    'Description for movie ' || s.i,
    EXTRACT(DAY FROM CURRENT_DATE - (s.i % 3650 || ' days')::interval)::INT,
    EXTRACT(MONTH FROM CURRENT_DATE - (s.i % 3650 || ' days')::interval)::INT,
    EXTRACT(YEAR FROM CURRENT_DATE - (s.i % 3650 || ' days')::interval)::INT,
    (random() * 180 + 90)::int
FROM generate_series(1, 10000000) as s(i);  -- Adjust the upper limit for 10M records accordingly


-- Заполнение таблицы attribute_values
INSERT INTO attribute_values (movie_id, attribute_id, text_value, float_value, int_value, date_value, json_value)
SELECT
    (random() * 9999999 + 1)::int, -- Случайный movie_id
    attribute_id, -- Последовательный attribute_id
    CASE WHEN data_type = 'text' THEN 'Text value for attribute ' || attribute_id ELSE NULL END,
    CASE WHEN data_type = 'float' THEN (random() * 100)::float ELSE NULL END,
    CASE WHEN data_type = 'int' THEN (random() * 100)::int ELSE NULL END,
    CASE WHEN data_type = 'date' THEN CURRENT_DATE - (attribute_id % 3650 || ' days')::interval ELSE NULL END,
    CASE WHEN data_type = 'text' THEN jsonb_build_object('key', 'value') ELSE NULL END
FROM attributes;

SELECT count(*) from attribute_types;
SELECT count(*) from attribute_values;
SELECT count(*) from attributes;
SELECT count(*) from movies;