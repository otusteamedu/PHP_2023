DO
$do$
    declare
        session_id integer[];
        cinema_hall_id integer[];
        ch_id integer;
        s_id integer;
    BEGIN
        cinema_hall_id := array(select id from cinema_hall);
        session_id := array(select id from session);
        foreach s_id in array session_id
        loop
            foreach ch_id in array cinema_hall_id
            loop
                insert into session_place
                    (session_id, cinema_hall_places_id, status)
                    values (s_id, ch_id, floor(random()*(2)));
            end loop;
        end loop;
    END
$do$;