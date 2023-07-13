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