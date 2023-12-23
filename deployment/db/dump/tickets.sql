create table tickets
(
    id         serial
        primary key,
    session_id integer        not null
        constraint fk_session
            references sessions,
    seat_id    integer        not null
        constraint fk_seat
            references seats,
    price      numeric(10, 2) not null
);

alter table tickets
    owner to postgres;

INSERT INTO public.tickets (id, session_id, seat_id, price) VALUES (1, 1, 1, 10.00);
INSERT INTO public.tickets (id, session_id, seat_id, price) VALUES (2, 2, 2, 15.00);
INSERT INTO public.tickets (id, session_id, seat_id, price) VALUES (3, 3, 1, 15.00);
