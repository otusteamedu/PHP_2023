create table halls
(
    id        serial
        primary key,
    cinema_id integer      not null
        constraint fk_cinema
            references cinemas,
    name      varchar(255) not null,
    capacity  integer      not null
);

alter table halls
    owner to postgres;

INSERT INTO public.halls (id, cinema_id, name, capacity) VALUES (1, 1, 'Hall 1', 150);
INSERT INTO public.halls (id, cinema_id, name, capacity) VALUES (2, 1, 'Hall 2', 200);
INSERT INTO public.halls (id, cinema_id, name, capacity) VALUES (3, 2, 'Main Hall', 250);
