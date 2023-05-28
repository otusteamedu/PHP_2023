create or replace view marketing_data as
select
    `otus`.`Movies`.`name` AS `name`,
    `otus`.`Attribute_types`.`name`  AS `attribute_type`,
    `otus`.`Attributes`.`name` AS `attribute`,
    case
        when `otus`.`Attribute_types`.`name` = 'Рецензия' then `otus`.`Attribute_values`.`text_value`
        when `otus`.`Attribute_types`.`name` = 'Премия' then `otus`.`Attribute_values`.`bool_value`
        when `otus`.`Attribute_types`.`name` = 'Важная дата' then `otus`.`Attribute_values`.`date_value`
        when `otus`.`Attribute_types`.`name` = 'Служебная дата'
        then `otus`.`Attribute_values`.`date_value`
    end
    AS `value`
from
    `otus`.`Movies`
    left join `otus`.`Attribute_values` on (`otus`.`Movies`.`id` = `otus`.`Attribute_values`.`movie_id`)
    left join `otus`.`Attributes` on (`otus`.`Attribute_values`.`attribute_id` = `otus`.`Attributes`.`id`)
    left join `otus`.`Attribute_types` on (`otus`.`Attributes`.`attribute_type_id` = `otus`.`Attribute_types`.`id`);