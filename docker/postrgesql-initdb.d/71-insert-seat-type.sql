set my.cnt_type = 10;

INSERT INTO public.seat_type ("name")
select
    concat('Тип места ', to_char(number, '00000000')) as name
FROM
    GENERATE_SERIES(1, current_setting('my.cnt_type')::int) as number;