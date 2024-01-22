--service_data
CREATE VIEW service_data AS
SELECT f.name                                                          as "Фильм",
       CASE WHEN av.value_datetime::date = CURRENT_DATE THEN av.value_datetime END AS "Задачи актуальные на сегодня",
       CASE WHEN av.value_datetime >= CURRENT_DATE + INTERVAL '20 days'
                THEN av.value_datetime END                                AS "Задачи актуальные через 20 дней"
FROM film f
     INNER JOIN attribute_value av
                on av.entity_id = f.id
                    AND av.entity_name = 'Film'
                    AND av.value_datetime > CURRENT_DATE
     INNER JOIN attribute a
                on av.attribute = a.id
ORDER BY av.value_datetime;


--marketing_data
CREATE VIEW marketing_data AS
SELECT f.name                       AS "Фильм",
       at.description               AS "Тип атрибута",
       a.name                       AS "атрибут",
       COALESCE(av.value_datetime::text, av.value_float::text, av.value_bool::text, av.value_text,
                av.value_int::text) AS "Значение"
FROM film f
     INNER JOIN attribute_value av
                on av.entity_id = f.id
                    AND av.entity_name = 'Film'
     INNER JOIN attribute a
                on av.attribute = a.id
     INNER JOIN attribute_type at
                on a.attribute_type = at.id;

--query
SELECT *
FROM service_data;

SELECT *
FROM marketing_data;
