set my.limit_min = 10;
set my.limit_max = 60;

do
$$
    declare
        person_r record;
        num int := 1;
        "limit" int;
    begin
        "limit" := floor(random() * (current_setting('my.limit_max')::int - current_setting('my.limit_min')::int + 1) + current_setting('my.limit_min')::int)::int;

        FOR person_r IN SELECT id from person p order by random() limit "limit" LOOP
                INSERT INTO public."person_city" (person_id, text) VALUES(person_r.id, concat('Город ', to_char(num, '000')));
                num := num + 1;
        END LOOP;
    end;
$$;
