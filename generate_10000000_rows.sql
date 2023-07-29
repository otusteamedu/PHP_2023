insert into film(id, name)
select generate_series(1, 10000000),
       random_string(3, 30);

insert into client(id, name, age, discount)
select generate_series(1, 10000000),
       random_string(3, 30),
       random_int(1, 120),
       random_int(0, 20);

insert into hall(id, name, class)
select generate_series(1, 10),
       random_string(3, 30),
       random_hall_class();

insert into scheme(id, hall_id, row, "column")
select generate_series(1, 10000000),
       random_int(1, 10),
       random_int(1, 15),
       random_int(1, 10);

insert into session(id, hall_id, film_id, date, price)
select generate_series(1, 10000000),
       random_int(1, 10),
       random_int(1, 10000000),
       random_date(2000, 2023),
       random_int(100, 3000);

insert into ticket(session_id, scheme_id, client_id, cost)
select random_int(1, 10000000),
       random_int(1, 10000000),
       random_int(1, 10000000),
       random_int(70, 3000)
from generate_series(1, 10000000);