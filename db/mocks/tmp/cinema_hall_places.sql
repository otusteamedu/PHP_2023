DO
$do$
    declare
        cinema_hall_id integer[];
        ch_id integer;
        rows integer;
        places integer;
    BEGIN
        cinema_hall_id := array(select id from cinema_hall);

        foreach ch_id in array cinema_hall_id
        loop
            rows := floor(random()*(10-5+1))+5;
            places := floor(random()*(15-8+1))+8;

            for row in 1..rows
            loop
                for place in 1..places
                loop
                    insert into cinema_hall_places
                        (cinema_hall_id, row, place)
                        values (ch_id, row, place);
                end loop;
            end loop;
        end loop;
    END
$do$;