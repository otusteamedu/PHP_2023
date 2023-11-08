-- Films
insert into films(
    id, name, genre, year_of_release, duration
)
select
    gs.id,
    rand_film_name() || ' ' || random_str((1 + random()*30)::integer),
    substr(md5(random()::text), 0, 254),
    rand_schedule_year(),
    rand_between(90, 320)
from
    generate_series(1, 10000) as gs(id);