CREATE OR REPLACE VIEW today_tasks AS
select f.id as film_id, a.name as task, v.date_value as date
from films as f
    inner join values v on f.id = v.film_id
    left join attributes a on v.attribute_id = a.id
    left join attribute_types at on v.type_id = at.id
where v.date_value::date = CURRENT_DATE
  and at.id = 4;

CREATE OR REPLACE VIEW tasks_for_20_days AS
select f.id as film_id, a.name as task,  v.date_value as date
from films as f
    inner join values v on f.id = v.film_id
    inner join attributes a on a.id = v.attribute_id
    inner join attribute_types at on at.id = v.type_id
where v.date_value::date between CURRENT_DATE and current_date + interval '20 days'
  and at.id = 4;

CREATE OR REPLACE VIEW film_tasks AS
select f.title, tt.task as task, tt.date
from films as f
         inner join today_tasks tt on f.id = tt.film_id
UNION DISTINCT
select f.title, t20.task as task, t20.date
from films as f
         inner join tasks_for_20_days t20 on f.id = t20.film_id;

CREATE OR REPLACE VIEW marketing_data AS
select f.title AS film_name,
       at.name AS attribute_type,
       a.name  AS attribute_name,
       case
           when v.text_value is not null then v.text_value::text
           when v.bool_value is not null then v.bool_value::text
           when v.date_value is not null then to_char(v.date_value, 'YYYY-MM-DD')::text
           when v.integer_value is not null then
               case
                   when at.id = 5 then (v.integer_value / 100)::text
                   else v.integer_value::text
                   end
           end as value
from values v
    inner join films f on v.film_id = f.id
    inner join attributes a on v.attribute_id = a.id
    inner join attribute_types at on v.type_id = at.id;
