select distinct f.title  from films f
join seances s ON s.film_id = f.id 
where s.start_at::date = current_date 

/*
title                   |
------------------------+
Бременские музыканты    |
Три богатыря и Пуп Земли|
Фильм 1                 |
Холоп 2                 |
*/