-- Заполнение таблицы "movies"
INSERT INTO movies (title)
SELECT 'Movie ' || id
FROM generate_series(1, 10000) AS id;

-- Заполнение таблицы "attributes"
INSERT INTO attributes (name)
SELECT 'Attribute ' || id
FROM generate_series(1, 10000) AS id;

-- Заполнение таблицы "attribute_types"
INSERT INTO attribute_types (name)
SELECT 'Attribute Type ' || id
FROM generate_series(1, 10000) AS id;

-- Заполнение таблицы "values"
INSERT INTO "values" (attribute_id, movie_id, attribute_type_id, string_value, boolean_value, date_value, int_value, float_value)
SELECT 
    (FLOOR(RANDOM() * 10000) + 1) AS attribute_id,
    (FLOOR(RANDOM() * 10000) + 1) AS movie_id,
    (FLOOR(RANDOM() * 10000) + 1) AS attribute_type_id,
    'Value ' || id AS string_value,
    (RANDOM() < 0.5) AS boolean_value,
    CURRENT_DATE - (FLOOR(RANDOM()::int * 365) + 1)::integer AS date_value,
    (FLOOR(RANDOM() * 100) + 1) AS int_value,
    (RANDOM() * 1000) AS float_value
FROM generate_series(1, 10000) AS id;

-- Заполнение таблицы "ticket_sales"
INSERT INTO ticket_sales (movie_id, sale_date, quantity)
SELECT 
    (FLOOR(RANDOM() * 10000) + 1) AS movie_id,
    CURRENT_DATE - (FLOOR(RANDOM()::int * 7) + 1)::integer AS sale_date,
    (FLOOR(RANDOM() * 100) + 1) AS quantity
FROM generate_series(1, 10000);

-- Заполнение таблицы "hall_schema"
INSERT INTO hall_schema (seat_number, row_number, is_vip)
SELECT 
    (FLOOR(RANDOM() * 100) + 1) AS seat_number,
    (FLOOR(RANDOM() * 10) + 1) AS row_number,
    (RANDOM() < 0.1) AS is_vip
FROM generate_series(1, 10000)
ON CONFLICT DO NOTHING;
