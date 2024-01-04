/* Выборка всех атрибутов всех фильмов */
CREATE VIEW marketing_data as SELECT
    movies.name, entity_attribute_types.datatype as attribute_type,
    entity_attributes.name as attribute_name,
    entity_attribute_values.value as attribute_value
FROM movies
INNER JOIN entity_attribute_values ON movies.id = entity_attribute_values.entity_id
INNER JOIN entity_attributes ON entity_attribute_values.attribute_id = entity_attributes.id
INNER JOIN entity_attribute_types ON entity_attributes.attribute_type = entity_attribute_types.id;

/* Задачи */

SELECT m.name, STRING_AGG(m.attribute_name, ',')
FROM (
     SELECT movies.id, movies.name, entity_attributes.name as attribute_name, entity_attribute_values.value as attribute_value FROM entity_attribute_values
     INNER JOIN entity_attributes ON entity_attributes.id = entity_attribute_values.attribute_id
     AND entity_attribute_values.attribute_id IN (
         SELECT entity_attributes.id FROM entity_attributes
         INNER JOIN entity_attribute_types ON entity_attributes.attribute_type = entity_attribute_types.id
         WHERE entity_attribute_types.datatype = 'DATETIME'
     )
     INNER JOIN movies ON entity_attribute_values.entity_id = movies.id
) m
WHERE CAST(m.attribute_value AS TIMESTAMP) < CURRENT_DATE
GROUP BY m.name

/*
 * Не работает, потому что не получается преобразовать тип строку в данные, возвращаются из кода не только даты,
 * а и другие строки (по сути sql в моменте преобразования возвращает все значения атрибутов, а должен только то что
 * подпадает под условия)
 */