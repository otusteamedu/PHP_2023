DO
$do$
    declare
        cinema_id integer;
        name text;
    BEGIN
        select id from cinema limit 1 into cinema_id;

        FOR i IN 1..10 LOOP
            name := concat('Зал №', i);

            INSERT INTO cinema_hall
            (cinema_id, name) values (cinema_id, name);
        END LOOP;
    END
$do$;