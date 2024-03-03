CREATE VIEW services_data AS
SELECT F.name as "Фильм",
       CASE WHEN AV.date = CURRENT_DATE THEN A.name ELSE '' END as "Задачи на сегодня",
       CASE WHEN AV.date > CURRENT_DATE + INTERVAL '20 days' THEN A.name ELSE '' END as "Задачи через 20 дней"
FROM films F
         INNER JOIN attribute_values AV ON AV.films_id = F.id
         INNER JOIN attributes A ON A.id = AV.attribute_id
         INNER JOIN attribute_types AT ON AT.id = A.type_id
WHERE AT.id = 4
  AND (AV.date = CURRENT_DATE
    OR AV.date > CURRENT_DATE + INTERVAL '20 days');

SELECT * FROM services_data;

CREATE VIEW marketing_data AS
SELECT M.name as "Фильмы",
       AT.name as "Типы атрибутов",
       A.name as "Атрибуты",
       COALESCE(
               AV.varchar,
               AV.bool::text,
               AV.integer::text,
               AV.float::text,
               AV.money::text,
               AV.date::text
       ) as "Значение"
FROM films M
         INNER JOIN attribute_values AV ON AV.films_id = M.id
         INNER JOIN attributes A ON A.id = AV.attribute_id
         INNER JOIN attribute_types AT ON AT.id = A.type_id
ORDER BY M.name, AT.name, A.name;

SELECT * FROM marketing_data;