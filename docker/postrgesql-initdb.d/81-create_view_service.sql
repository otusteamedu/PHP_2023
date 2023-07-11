CREATE OR REPLACE VIEW public.service
as
select movie.id, movie.name, today.today, "+20d"."+20d"
from movie
         left join (
    select mav.movie_id, string_agg(concat(ma."name", ',', mav.value), '; ') as today from movie_attributes_value as mav
                                                                                               LEFT JOIN movie_attributes ma ON mav.attribute_id = ma.id
    where
            mav.active = true and ma.parent_id  = 'c0f3fa24-7f39-4c8a-b92b-cdd9c43c0363' and ma.type_id = '64966228-bc4b-4216-b123-d10b6fa9fee1' and
            value::date = current_date
    group by mav.movie_id
) as today on today.movie_id=movie.id
         left join (
    select mav.movie_id, string_agg(concat(ma."name", ',', mav.value), '; ') as "+20d" from movie_attributes_value as mav
                                                                                                LEFT JOIN movie_attributes ma ON mav.attribute_id = ma.id
    where
            mav.active = true and ma.parent_id  = 'c0f3fa24-7f39-4c8a-b92b-cdd9c43c0363' and ma.type_id = '64966228-bc4b-4216-b123-d10b6fa9fee1' and
            value::date >= current_date + interval '20 days'
    group by mav.movie_id
) as "+20d" on "+20d".movie_id=movie.id