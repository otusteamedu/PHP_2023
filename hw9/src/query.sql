select film.id, film.name, Attribute.name, typeAttribute.name,
case
when typeAttribute.id=1 then valueAttribute.text_value
when typeAttribute.id=2 then valueAttribute.int_value::TEXT
when typeAttribute.id=3 then valueAttribute.bool_value::TEXT
when typeAttribute.id=4 then valueAttribute.num_value::TEXT
when typeAttribute.id=5 then valueAttribute.time_value::TEXT
end  attr_value
from film left join valueAttribute on film.id=valueAttribute.id_film
left join Attribute on attribute.id=valueAttribute.id_attribute
left join typeAttribute on typeAttribute.id=Attribute.id_type
order by film.id



select film.id, film.name, typeAttribute.name,
case when  to_char(valueAttribute.time_value, 'YYYY-MM-DD')=to_char(now(), 'YYYY-mm-dd') then Attribute.name end task_now,
case when  to_char(valueAttribute.time_value, 'YYYY-MM-DD')=to_char((now()+interval '20' day), 'YYYY-mm-dd') then Attribute.name end task_20
from film left join valueAttribute on film.id=valueAttribute.id_film
left join Attribute on attribute.id=valueAttribute.id_attribute
left join typeAttribute on typeAttribute.id=Attribute.id_type
where typeAttribute.id=5 and valueAttribute.time_value is not null
and (to_char(valueAttribute.time_value, 'YYYY-MM-DD')=to_char(now(), 'YYYY-mm-dd')
or  to_char(valueAttribute.time_value, 'YYYY-MM-DD')=to_char((now()+interval '20' day), 'YYYY-mm-dd'))
order by film.id