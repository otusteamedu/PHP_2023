set my.cnt_seat_number_min = 100;
set my.cnt_seat_number_max = 2500;

do
$$
    declare
        hall_r record;
        type_r record;
        row_count int;
        number_count int;
        cnt int;
    begin
        for hall_r in select id, seat from hall loop
            number_count := floor(random() * (current_setting('my.cnt_seat_number_max')::int - current_setting('my.cnt_seat_number_min')::int + 1) + current_setting('my.cnt_seat_number_min')::int)::int;
            row_count := hall_r.seat::int / number_count;
            if hall_r.seat::int % number_count <> 0 then
                row_count := row_count + 1;
            end if;

            raise notice '% - % = % / %', hall_r.id, hall_r.seat, row_count, number_count;

            cnt := 0;
            FOR i IN 1..row_count loop
                FOR k IN 1..number_count LOOP
                    select id into type_r from seat_type order by random() limit 1;
                    INSERT INTO public.seat (hall_id, "number", "row", type_id) VALUES(hall_r.id, k, i, type_r.id);
                    cnt:= cnt + 1;
                    if cnt >= hall_r.seat::int then
                        exit;
                    end if;
                END LOOP;
            END LOOP;
        end loop;
    end;
$$;
