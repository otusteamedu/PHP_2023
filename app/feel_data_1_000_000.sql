-- генерируем 10 000 записей

-- movies
insert into movie (
    id, title, description, premier_date, duration
)
select
    gs.id,
    random_movie_name() || ' ' || random_str((1 + random()*30)::integer),
    random_str((2+random()*48)::integer),
    random_date_time_between('2000-01-01', '2022-12-31'),
    random_int_between(90, 320)
from
    generate_series(1, 10000) as gs(id);

-- places
INSERT INTO place (id, row, number, hall_id, place_type_id)
select
    gs.id,
    random_int_between(1, 10),
    random_int_between(1, 20),
    random_int_between(1, 4),
    random_int_between(1, 3)
from generate_series(1, 100) as gs(id);

-- clients
insert into client (id, name, phone)
select
    g.id,
    substr(md5(random()::text), 0, 20),
    floor(random() * (10000000000 - 1 + 1) + 1)::text
from
    generate_series(1, 10000) as g(id);

-- prices
insert into price (id, price)
select gs.id,
       random_int_between(300, 1000)
from generate_series(1, 100) as gs(id);

-- sessions
INSERT INTO session (id, hall_id, movie_id, date, time)
select
    gs.id,
    random_int_between(1, 4),
    random_int_between(1, 10000),
    random_date_time_between('2017-01-01', '2023-12-31'),
    random_schedule_time()
from generate_series(1, 100000) as gs(id);

-- prices
insert into price (id, price, session_id, place_id)
select gs.id,
       random_int_between(300, 1000),
       random_int_between(300, 10000),
       random_int_between(1, 100)
from generate_series(1, 1000000) as gs(id);

-- tickets
INSERT INTO ticket (id, client_id, session_id, created_at, place_id)
select
    gs.id,
    random_int_between(1, 10000),
    random_int_between(1, 10000),
    random_date_time_between('2017-01-01', '2023-12-31'),
    random_int_between(1, 100)
from generate_series(1, 1000000) as gs(id);
