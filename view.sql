CREATE VIEW service_data AS
SELECT m.name, v.value AS "Сегодня", v2.value AS "Через 20 дней"
FROM movie m
         LEFT JOIN value v ON m.id = v.movie_id AND v.attribute_id = 4
         LEFT JOIN value v2 ON m.id = v2.movie_id AND v2.attribute_id = 4 AND v2.value::date = (current_date + interval '20 days');

CREATE VIEW marketing AS
SELECT m.name, t.name as type, a.name as attribute, v.value::text
FROM movie m
         JOIN value v ON m.id = v.movie_id
         JOIN attribute a ON v.attribute_id = a.id
         JOIN attribute_type t ON a.attribute_type_id = t.id;