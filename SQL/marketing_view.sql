create view marketing_view(cinema, attribute, attrtype, value) as
SELECT c.name                                                                       AS cinema,
       a.name                                                                       AS attribute,
       t.type                                                                       AS attrtype,
       COALESCE(v.text, v.bool::text, v.date::text, v.float::text, v.integer::text) AS value
FROM cinema c
         JOIN value v ON c.id = v.cinema_id
         JOIN attribute a ON a.id = v.attribute_id
         JOIN attribute_type t ON t.id = a.type_id;