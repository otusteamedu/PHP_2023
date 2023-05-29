create or replace view service_tasks as
select `otus`.`Movies`.`name` AS `name`, `today_tasks`.`tasks_list` AS `today_tasks_list`, `future_tasks`.`tasks_list` AS `future_tasks_list`
from `otus`.`Movies`
         left join
     (
         select `otus`.`Movies`.`id` AS `movie_id`, group_concat(`otus`.`Attributes`.`name` separator '; ') AS `tasks_list`
         from `otus`.`Movies` left join `otus`.`Attribute_values` on (`otus`.`Movies`.`id` = `otus`.`Attribute_values`.`movie_id`)
                              left join `otus`.`Attributes` on (`otus`.`Attribute_values`.`attribute_id` = `otus`.`Attributes`.`id`)
                              left join `otus`.`Attribute_types` on (`otus`.`Attributes`.`attribute_type_id` = `otus`.`Attribute_types`.`id`)
         where `otus`.`Attribute_types`.`id` = 4
           and `otus`.`Attribute_values`.`date_value` = curdate()
         group by `otus`.`Movies`.`id`
         order by `otus`.`Movies`.`id`
     ) `today_tasks`
     on (`today_tasks`.`movie_id` = `otus`.`Movies`.`id`)
         left join
     (
         select `otus`.`Movies`.`id` AS `movie_id`, group_concat(`otus`.`Attributes`.`name` separator '; ') AS `tasks_list`
         from `otus`.`Movies` left join `otus`.`Attribute_values` on (`otus`.`Movies`.`id` = `otus`.`Attribute_values`.`movie_id`)
                              left join `otus`.`Attributes` on (`otus`.`Attribute_values`.`attribute_id` = `otus`.`Attributes`.`id`)
                              left join `otus`.`Attribute_types` on (`otus`.`Attributes`.`attribute_type_id` =`otus`.`Attribute_types`.`id`)
         where `otus`.`Attribute_types`.`id` = 4
           and `otus`.`Attribute_values`.`date_value` = curdate() + interval 20 day
         group by `otus`.`Movies`.`id`
         order by `otus`.`Movies`.`id`
     ) `future_tasks`
     on (`future_tasks`.`movie_id` = `otus`.`Movies`.`id`);