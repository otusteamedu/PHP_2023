-- films
insert into movies(id, name, duration)
select gs.id,
       rand_movie_name() || ' ' || rand_str((1 + random() * 30)::integer),
       rand_between(90, 320)
from generate_series(1, 100000) as gs(id);

--halls
insert into halls(id, name)
select gs.id,
       rand_str(10)
from generate_series(1, 10) as gs(id);

--showtime
insert into showtime(id, movie_id, hall_id, start_time, end_time)
select gs.id,
       rand_between(1, 10),
       rand_between(1, 10),
       rand_date_time('2023-11-01', '2023-12-31'),
       rand_date_time('2023-11-01', '2023-12-31')

from generate_series(1, 1000) as gs(id);

--seat_in_halls
insert into seats_in_halls(id, hall_id, row, seats)
select gs.id,
       rand_between(1, 10),
       rand_between(1, 15),
       rand_between(1, 30)
from generate_series(1, 1000) as gs(id);

--customers
INSERT INTO customers (id, name, phone)
select gs.id,
       rand_str(10),
       rand_between(1, 1000)
from generate_series(1, 10000) as gs(id);

-- tickets
INSERT INTO tickets (id, price, showtime_id, customer_id, seat_in_hall_id)
select gs.id,
       rand_between(1, 100),
       rand_between(1, 1000),
       rand_between(1, 4500),
       rand_between(1, 1000)

from generate_series(1, 10000000) as gs(id);
