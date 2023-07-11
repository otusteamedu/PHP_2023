set my.price_min = 50;
set my.price_max = 1000;

do
$$
    declare
        session_r record;
        seat_r record;
        price int;
    begin
        for session_r in select id, hall_id from "session" loop
            for seat_r in select id from "seat" where hall_id = session_r.hall_id and active = true loop
                price := floor(random() * (current_setting('my.price_max')::int - current_setting('my.price_min')::int + 1) + current_setting('my.price_min')::int)::int;
                INSERT INTO public.ticket (session_id, seat_id, price, status) values (session_r.id, seat_r.id, price, round(random()));
            end loop;
        END LOOP;
    end;
$$;
