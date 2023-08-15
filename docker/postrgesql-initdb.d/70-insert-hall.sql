set my.cnt_hall = 10000;
set my.cnt_hall_seat_min = 20;
set my.cnt_hall_seat_max = 100;
INSERT INTO public.hall ("name", seat, active)
select
    concat('Зал ', to_char(number, '00000000')) as name,
    floor(random() * (current_setting('my.cnt_hall_seat_max')::int - current_setting('my.cnt_hall_seat_min')::int + 1) + current_setting('my.cnt_hall_seat_min')::int)::int as seat,
    random() > 0.5 as active
FROM
    GENERATE_SERIES(1, current_setting('my.cnt_hall')::int) as number;
