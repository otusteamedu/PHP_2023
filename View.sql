create view today_task as
select f.id as film_id, a.name as task
from films as f
inner join value v on f.id = v.film_id
inner join attributes a on a.id = v.attribute_id
inner join type t on t.id = a.type_id
where v.date_value::date = CURRENT_DATE and
t.name = 'Служебные даты';

create view task_in_20_days as
select f.id as film_id, a.name as task
from films as f
inner join value v on f.id = v.film_id
inner join attributes a on a.id = v.attribute_id
inner join type t on t.id = a.type_id
where v.date_value::date between current_date and current_date + interval '20 days' and
t.name = 'Служебные даты';

create view film_task as
select f.name, t.task as today_task, t20.task as task_in_20_days
from films as f
inner join today_task t on f.id = t.film_id
inner join task_in_20_days t20 on f.id = t20.film_id;

create view marketing_data as
select f.name, t.name, a.name, v.int_value, v.float_value, v.bool_value, v.date_value, v.text_value
from value v
inner join films f on f.id = v.film_id
inner join attributes a on a.id = v.attribute_id
inner join type t on t.id = a.type_id