CREATE VIEW services_data AS
    SELECT M.name as "Фильм",
           CASE WHEN AV.val_date = CURRENT_DATE THEN A.name ELSE '' END as "Задачи на сегодня",
           CASE WHEN AV.val_date = CURRENT_DATE + INTERVAL '20 days' THEN A.name ELSE '' END as "Задачи через 20 дней"
    FROM movies M
             INNER JOIN attribute_values AV ON AV.movie_id = M.id
             INNER JOIN attributes A ON A.id = AV.attribute_id
             INNER JOIN attribute_types AT ON AT.id = A.type_id
    WHERE AT.id = 4
      AND (AV.val_date = CURRENT_DATE
               OR AV.val_date = CURRENT_DATE + INTERVAL '20 days');

SELECT * FROM services_data;

CREATE VIEW marketing_data AS
    SELECT M.name as "Фильмы",
           AT.name as "Типы аттрибутов",
           A.name as "Аттрибуты",
           COALESCE(
                   AV.val_text,
                   AV.val_bool::text,
                   AV.val_int::text,
                   AV.val_float::text,
                   AV.val_date::text
           ) as "Значение"
    FROM movies M
             INNER JOIN attribute_values AV ON AV.movie_id = M.id
             INNER JOIN attributes A ON A.id = AV.attribute_id
             INNER JOIN attribute_types AT ON AT.id = A.type_id
    ORDER BY M.name ASC, AT.name ASC, A.name ASC;

SELECT * FROM marketing_data;
