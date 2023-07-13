DO
$do$
    declare
        session_id    integer[];
        s_id          integer;
        count_tickets integer;
        price         float;
        sp_id         integer;
        days          integer;
        datetime      timestamp;
        c_id          integer;
    BEGIN
        session_id := array(select id from session);
        foreach s_id in array session_id
            loop
                count_tickets := floor(random() * (10 - 1)) + 1;
                for t in 1..count_tickets
                    loop
                        days := floor(random() * (30));
                        if floor(random() * (2)) < 1 then
                            datetime := now() - days * interval '1 day';
                        else
                            datetime := now() + days * interval '1 day';
                        end if;
                        insert into checkout
                            (date)
                        values (datetime);
                        select currval(pg_get_serial_sequence('checkout', 'id')) into c_id;
                        price := floor(random() * (1000 - 250 + 1)) + 250;
                        sp_id := floor(random() * (1000)) + 1;
                        insert into ticket
                            (session_id, session_place_id, price, checkout_id)
                        values (s_id, sp_id, price, c_id);
                    end loop;
            end loop;
    END
$do$;