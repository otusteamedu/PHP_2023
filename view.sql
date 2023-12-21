CREATE VIEW marketing_view AS
SELECT movies.name                                        AS movie_name,
       CONCAT(attributes_type.name, ' ', attributes.name) as attribute,
       COALESCE(
               attributes_values.val_text,
               attributes_values.val_date ::text,
               attributes_values.val_timestamp ::text,
               attributes_values.val_num ::text,
               attributes_values.val_bool ::text,
               attributes_values.val_int ::text,
               attributes_values.val_float ::text
       )                                                  AS attribute_val
FROM attributes_values
         LEFT JOIN movies ON movies.id = attributes_values.movie_id
         LEFT JOIN attributes ON attributes.id = attributes_values.attribute_id
         LEFT JOIN attributes_type ON attributes_type.id = attributes.attribute_type_id
ORDER BY movies.name;