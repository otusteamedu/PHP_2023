/*
1. Из hall выбираем hall_id, Пример hall_id = '70ec0aea-181a-4198-9d23-a24e33be2d5a'
2. Из sessions по hall_id выбираем session_id, Пример session_id = 'ef3543d1-d2d7-4fc1-b79c-0bdd3af84aaf'
3. Из ticket по session_id выбираем места
*/
select s."row", s."number", t.price,
    case
        when t.status in (0) then 'Свободно'
        when t.status in (1,10) then 'Занято'
        when t.status in (2) then 'Бронь'
    end
from seat s
left join ticket t on s.id=t.seat_id
where hall_id = '70ec0aea-181a-4198-9d23-a24e33be2d5a'  and t.session_id = 'ef3543d1-d2d7-4fc1-b79c-0bdd3af84aaf'
order by "row" asc , number::int asc
