CREATE VIEW staff_view AS
    WITH today_tasks AS (
    SELECT films.name as film_name, attributes.name as attribute_name_today FROM attribute_values
         LEFT JOIN films ON films.id = attribute_values.film_id
         LEFT JOIN attributes ON attributes.id = attribute_values.attribute_id
         LEFT JOIN attribute_types ON attribute_types.id = attributes.attribute_type_id
    WHERE attribute_values.datetime_val between CONCAT(DATE(CURDATE()), ' 00:00:00') AND CONCAT(DATE(CURDATE()), ' 23:59:59')),
    twenty_day_tasks AS (
    SELECT films.name as film_name, attributes.name as attribute_name_twentyday FROM attribute_values
        LEFT JOIN films ON films.id = attribute_values.film_id
        LEFT JOIN attributes ON attributes.id = attribute_values.attribute_id
        LEFT JOIN attribute_types ON attribute_types.id = attributes.attribute_type_id
    WHERE attribute_values.datetime_val between CONCAT(DATE_ADD(CURDATE(), INTERVAL 20 DAY), ' 00:00:00') AND CONCAT(DATE_ADD(CURDATE(), INTERVAL 20 DAY), ' 23:59:59'))
    SELECT COALESCE(today_tasks.film_name, twenty_day_tasks.film_name) AS film_name, attribute_name_today AS "Задачи на сегодня",
           attribute_name_twentyday AS "Задачи через 20 дней"
        from today_tasks, twenty_day_tasks;


CREATE VIEW marketing_view AS
SELECT films.name AS film_name, attribute_types.name AS attribute_type, attributes.name AS attribute,
    COALESCE(attribute_values.text_val, CONVERT(attribute_values.numeric_val,char), CONVERT(attribute_values.price_val,char))
    AS attr_val
FROM attribute_values
    LEFT JOIN films ON films.id = attribute_values.film_id
    LEFT JOIN attributes ON attributes.id = attribute_values.attribute_id
    LEFT JOIN attribute_types ON attribute_types.id = attributes.attribute_type_id
WHERE COALESCE(attribute_values.text_val, CONVERT(attribute_values.numeric_val,char), CONVERT(attribute_values.price_val,char)) is not null
ORDER BY attribute_types.name;

