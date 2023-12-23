create table sessions
(
    id         serial
        primary key,
    hall_id    integer   not null
        constraint fk_hall
            references halls,
    movie_id   integer   not null
        constraint fk_movie
            references movies,
    start_time timestamp not null
);

alter table sessions
    owner to postgres;

INSERT INTO public.sessions (id, hall_id, movie_id, start_time) VALUES (1, 1, 1, '2023-04-01 14:00:00.000000');
INSERT INTO public.sessions (id, hall_id, movie_id, start_time) VALUES (2, 1, 2, '2023-04-01 17:00:00.000000');
INSERT INTO public.sessions (id, hall_id, movie_id, start_time) VALUES (3, 2, 3, '2023-04-01 20:00:00.000000');
