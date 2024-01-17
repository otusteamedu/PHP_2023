CREATE VIEW service_data AS
SELECT f.name                                                          as "Фильм",
       CASE WHEN av.value::date = CURRENT_DATE THEN av.value::date END AS "Задачи актуальные на сегодня",
       CASE WHEN av.value::date >= CURRENT_DATE + INTERVAL '20 days'
                THEN av.value::date END                                AS "Задачи актуальные через 20 дней"
FROM film f
     INNER JOIN attribute_value av
                on av.entity_id = f.id
                    AND av.entity_name = 'Film'
                    AND av.attribute IN (3, 4, 5)
     INNER JOIN attribute a
                on av.attribute = a.id
ORDER BY av.value;

CREATE VIEW marketing_data AS
SELECT f.name         AS "Фильм",
       at.description AS "Тип атрибута",
       a.name         AS "атрибут",
       av.value       AS "Значение"
FROM film f
     INNER JOIN attribute_value av
                on av.entity_id = f.id
                    AND av.entity_name = 'Film'
     INNER JOIN attribute a
                on av.attribute = a.id
     INNER JOIN attribute_type at
                on a.attribute_type = at.id;


SELECT *
FROM service_data;

SELECT *
FROM marketing_data;
