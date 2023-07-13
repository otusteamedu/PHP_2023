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

        for i in 1..30
        loop
            date := date + INTERVAL '1 day';
            for j in 1..count_movie_per_day
            loop
                index := floor(random()*(length))+1;
                m_id := movie_id[index];
                insert into session
                    (cinema_hall_id, movie_id, start_date, end_date)
                    values (cinema_hall_id, m_id, date, date);
            end loop;
        end loop;
    END
$do$;