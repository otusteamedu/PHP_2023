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

--Halls
insert into halls(
                  id, name, rows_number, seats_number
)
select
    gs.id,
    rand_str( 10),
    rand_between(30, 100),
    rand_between(30, 100)
from
    generate_series(1, 10) as gs(id);

--Sessions
insert into sessions(
    id, datetime, hall_id, film_id
)
select
    gs.id,
    rand_date_time('2023-11-01', '2023-12-31'),
    rand_between(1, 10),
    rand_between(1, 10000)
from
    generate_series(1, 1000) as gs(id);