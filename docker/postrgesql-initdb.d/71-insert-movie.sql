set my.cnt_movie = 2000;
set my.cnt_movie_release_min = '2000-01-01';
set my.cnt_movie_release_max = '2030-01-01';
set my.cnt_movie_length_min = 20;
set my.cnt_movie_length_max = 40;

INSERT INTO public.movie ("name", release_date , description, length_minute)
select
    concat('Фильм ', to_char(number, '000000')) as name,
    DATE(current_setting('my.cnt_movie_release_min')::timestamp + (random() * (current_setting('my.cnt_movie_release_max')::timestamp - current_setting('my.cnt_movie_release_min')::timestamp)))  as release_date,
    concat('Описание фильма ', to_char(number, '000000')) as description,
    floor(random() * (current_setting('my.cnt_movie_length_max')::int - current_setting('my.cnt_movie_length_min')::int + 1) + current_setting('my.cnt_movie_length_min')::int)::int as length_minute

FROM
    GENERATE_SERIES(1, current_setting('my.cnt_movie')::int) as number;
