/* Выборка всех атрибутов всех фильмов */
CREATE VIEW marketing_data as SELECT
    movies.name, entity_attribute_types.datatype as attribute_type,
    entity_attributes.name as attribute_name,
    (coalesce(
        entity_attribute_values.value_string::text,
        entity_attribute_values.value_float::text,
        entity_attribute_values.value_date::text,
        entity_attribute_values.value_timestamp::text,
        entity_attribute_values.value_boolean::text
    )) as attribute_value
FROM movies
INNER JOIN entity_attribute_values ON movies.id = entity_attribute_values.entity_id
INNER JOIN entity_attributes ON entity_attribute_values.attribute_id = entity_attributes.id
INNER JOIN entity_attribute_types ON entity_attributes.attribute_type = entity_attribute_types.id;

/* Задачи */


CREATE VIEW today_tasks AS SELECT movies.name, STRING_AGG(entity_attributes.name, ',') as today_tasks
FROM entity_attribute_values
INNER JOIN entity_attributes ON entity_attributes.id = entity_attribute_values.attribute_id
INNER JOIN entity_attribute_types ON entity_attribute_types.id = entity_attributes.attribute_type
INNER JOIN movies ON entity_attribute_values.entity_id = movies.id
WHERE entity_attribute_types.name = 'Служебные даты'
AND entity_attribute_values.value_timestamp = CURRENT_DATE
GROUP BY movies.id;

CREATE VIEW after_20_days_tasks AS SELECT movies.name, STRING_AGG(entity_attributes.name, ',') as after_20_days_tasks
FROM entity_attribute_values
         INNER JOIN entity_attributes ON entity_attributes.id = entity_attribute_values.attribute_id
         INNER JOIN entity_attribute_types ON entity_attribute_types.id = entity_attributes.attribute_type
         INNER JOIN movies ON entity_attribute_values.entity_id = movies.id
WHERE entity_attribute_types.name = 'Служебные даты'
  AND entity_attribute_values.value_timestamp = CURRENT_DATE + INTERVAL '20 day'
GROUP BY movies.id;