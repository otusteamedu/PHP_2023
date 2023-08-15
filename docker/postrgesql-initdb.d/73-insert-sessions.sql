set my.date_start = '2023-08-01';
set my.date_end = '2023-09-01';

set my.time_start = '06:00:00';
set my.time_end = '23:00:00';

set my.movie_interval = '10';

set my.ad_length = 5;

do
$$
    declare
        hall_r record;
        movie_r record;
        curr record;

        time_start timestamp;
        time_end timestamp;
        time_curr timestamp;
        len int;
    begin
        FOR curr IN SELECT generate_series(current_setting('my.date_start')::date, current_setting('my.date_end')::date, '1 day'::interval) LOOP
            time_start = Date(curr.generate_series) + current_setting('my.time_start')::time;
            time_end = Date(curr.generate_series) + current_setting('my.time_end')::time;

            raise notice 'date %', Date(curr.generate_series);

            for hall_r in select id from hall where active = true loop
                time_curr := time_start;
                    while time_curr < time_end loop
                        select id, length_minute into movie_r from movie order by random() limit 1;

                        len := movie_r.length_minute::int + current_setting('my.ad_length')::int;

                        INSERT INTO public."session" (hall_id, movie_id, start_time, length_minute) VALUES(hall_r.id, movie_r.id, time_curr, len);

                        time_curr := time_curr + concat(movie_r.length_minute, ' minutes')::interval + concat(current_setting('my.movie_interval'), ' minutes')::interval;
                    end loop;
            end loop;
        END LOOP;
    end;
$$;
