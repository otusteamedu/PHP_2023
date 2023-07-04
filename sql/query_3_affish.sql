SELECT movies.title, values.date_value AS start_time
FROM movies
JOIN "values" ON "values".movie_id = movies.id
JOIN attributes ON attributes.id = "values".attribute_id
JOIN attribute_types ON attribute_types.id = "values".attribute_type_id
WHERE attributes.name = 'Время начала'
  AND attribute_types.name = 'Дата/Время'
  AND "values".date_value::date = CURRENT_DATE;

