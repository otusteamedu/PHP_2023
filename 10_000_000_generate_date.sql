-- генератор на 10000000 записей

-- Films
insert into films(
    id, title, description, poster, premier_date, duration
)
select
    gs.id,
    rand_film_name() || ' ' || random_str((1 + random()*30)::integer),
    substr(md5(random()::text), 0, 254),
    random_str((2+random()*48)::integer),
    rand_date_time('2000-01-01', '2022-12-31'),
    rand_between(90, 320)
from
    generate_series(1, 100000) as gs(id);


-- Places  
INSERT INTO places (id, row, position, hall_id, type_place_id) 
select
    gs.id,
    rand_between(1, 7),
    rand_between(1, 15),
    rand_between(1, 4),
    rand_between(1, 3)
from generate_series(1, 100) as gs(id);


-- Clients
insert into clients (id, name, phone, email)
select 
    g.id,
    substr(md5(random()::text), 0, 20),
    floor(random() * (10000000000 - 1 + 1) + 1)::text,
   'test _@' || substr(md5(random()::text), 0, 20) || '.com'
from
    generate_series(1, 10000) as g(id);


-- Prices
insert into prices (id, price)
select gs.id,
       rand_between(100, 800)
from generate_series(1, 100) as gs(id);


-- Sessions
INSERT INTO sessions ("id", "hall_id", "film_id", "price_id", "time", "day", "year")
    select
        gs.id,
        rand_between(1, 4),
        rand_between(1, 10000),
        rand_between(1, 100),
        rand_schedule_time(),
        rand_schedule_day(),
        rand_schedule_year()
    from generate_series(1, 100000) as gs(id);


-- Tickets
INSERT INTO tickets ("id", "client_id", "session_id", "cashier_id", "buyed_at", "place_id")
    select
        gs.id,
        rand_between(1, 10000),
        rand_between(1, 10000),
        rand_between(1, 4),
        rand_date_time('2021-01-01', '2023-06-30'),
        rand_between(1, 100)
    from generate_series(1, 10000000) as gs(id);