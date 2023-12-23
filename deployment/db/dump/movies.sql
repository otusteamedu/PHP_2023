create table movies
(
    id           serial
        primary key,
    title        varchar(255) not null,
    duration     integer      not null,
    release_date date         not null
);

alter table movies
    owner to postgres;

INSERT INTO public.movies (id, title, duration, release_date) VALUES (1, 'The Grand Journey', 120, '2023-01-01');
INSERT INTO public.movies (id, title, duration, release_date) VALUES (2, 'Comedy Nights', 90, '2023-02-01');
INSERT INTO public.movies (id, title, duration, release_date) VALUES (3, 'Space Adventure', 130, '2023-03-01');
