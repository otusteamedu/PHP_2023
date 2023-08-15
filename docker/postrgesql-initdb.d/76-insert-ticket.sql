set my.price_min = 50;
set my.price_max = 1000;

do
$$
    declare
        session_r record;
        seat_r record;
        price_r record;
        price_ int;
        price_default int;
    begin
        select "price" into price_r from price_catalog where id = '00000000-0000-0000-0000-000000000000';
        price_default := price_r.price;

        for session_r in select id, hall_id from "session" loop
            for seat_r in select id, type_id from "seat" where hall_id = session_r.hall_id and active = true loop
                /*price := floor(random() * (current_setting('my.price_max')::int - current_setting('my.price_min')::int + 1) + current_setting('my.price_min')::int)::int;*/
                select "price" into price_r from price_catalog where session_id = session_r.id and seat_type_id = seat_r.type_id;
                if price_r is not null then
                    price_ := price_r.price;
                else
                    price_ := price_default;
                end if;

                INSERT INTO public.ticket (session_id, seat_id, "price", status) values (session_r.id, seat_r.id, price_, round(random()));
            end loop;
        END LOOP;
    end;
$$;
