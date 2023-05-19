create view official_view(cinema, today_attribute, day_20_attribute) as
SELECT c.name AS cinema,
       a.name AS today_attribute,
       a.name AS day_20_attribute
FROM cinema c
         JOIN value v ON c.id = v.cinema_id
         JOIN attribute a ON a.id = v.attribute_id
         JOIN attribute_type t ON t.id = a.type_id
WHERE t.type::text = 'official'::text
  AND (v.date = CURRENT_DATE OR v.date = (CURRENT_DATE + '20 days'::interval));