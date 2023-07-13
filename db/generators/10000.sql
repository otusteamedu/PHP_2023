insert into movie (name)
select random_string(15)
from generate_series(1, 100);

insert into session (cinema_hall_id, movie_id, start_date)
select floor(random() * 10) + 1,
       floor(random() * 100) + 1,
       random_date(30)
from generate_series(1, 2500);

insert into session_movie_price (movie_id, session_id, price)
select floor(random() * (100)) + 1,
       floor(random() * (2500)) + 1,
       floor(random() * (1500 - 200 + 1)) + 200
from generate_series(1, 2500);

insert into session_place (session_id, cinema_hall_places_id, status)
select floor(random() * (10000)) + 1,
       floor(random() * (10000)) + 1,
       floor(random() * 2)
from generate_series(1, 2500);

insert into ticket (session_id, session_place_id, price)
select floor(random() * (2500)) + 1,
       floor(random() * (2500)) + 1,
       floor(random() * (1500 - 200 + 1)) + 200
from generate_series(1, 2500);
