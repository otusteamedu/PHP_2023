-- кинотеатры
insert into cinema (name) values ('Кинотеатр 1');

-- кинозалы
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

-- места в кинозалах
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

-- фильмы
insert into movie (name) values ('Хэнкок');
insert into movie (name) values ('Бладшот');
insert into movie (name) values ('Грязь');
insert into movie (name) values ('Чужой: Царство человека');
insert into movie (name) values ('Обливион');
insert into movie (name) values ('Хроники хищных городов');
insert into movie (name) values ('Парень с того света');

-- сеансы
DO
$do$
    declare
        movie_id integer[];
        cinema_hall_id integer;
        length integer;
        m_id integer;
        index integer;
        date timestamp;
        count_movie_per_day integer := 10;
    BEGIN
        movie_id := array(select id from movie);
        select id from cinema_hall limit 1 into cinema_hall_id;
        length := array_length(movie_id, 1);

        date := now();

        for i in 1..60
            loop
                for j in 1..count_movie_per_day
                    loop
                        index := floor(random()*(length))+1;
                        m_id := movie_id[index];
                        insert into session
                        (cinema_hall_id, movie_id, start_date, end_date)
                        values (cinema_hall_id, m_id, date, date);
                    end loop;
                date := date + INTERVAL '1 day';
            end loop;
    END
$do$;

-- цены на сеансы
DO
$do$
    declare
        session_id integer[];
        movie_id integer[];
        m_id integer;
        s_id integer;
        price float;
    BEGIN
        movie_id := array(select id from movie);
        foreach m_id in array movie_id
            loop
                session_id := array(select id from session);
                foreach s_id in array session_id
                    loop
                        price := floor(random()*(1000 - 250 + 1))+250;
                        insert into session_movie_price
                        (movie_id, session_id, price)
                        values (m_id, s_id, price);
                    end loop;
            end loop;
    END
$do$;

-- занятость мест на сеансы
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

-- билеты
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