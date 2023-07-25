set my.price_min = 50;
set my.price_max = 1000;

do
$$
    declare
        session_r record;
        type_r record;
        price int;
    begin
        INSERT INTO public.price_catalog (id, price) values ('00000000-0000-0000-0000-000000000000', 10000);

        for session_r in select id from "session" loop
            for type_r in select id from "seat_type" loop
                price := floor(random() * (current_setting('my.price_max')::int - current_setting('my.price_min')::int + 1) + current_setting('my.price_min')::int)::int;
                INSERT INTO public.price_catalog (session_id, seat_type_id, price) values (session_r.id, type_r.id, price);
            end loop;
        END LOOP;
    end;
$$;
