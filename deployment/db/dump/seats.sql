create table seats
(
    id                serial
        primary key,
    hall_id           integer not null
        constraint fk_hall_seats
            references halls,
    row_number        integer not null,
    seat_number       integer not null,
    price_category_id integer
        constraint fk_price_category_seats
            references price_categories
);

alter table seats
    owner to postgres;

INSERT INTO public.seats (id, hall_id, row_number, seat_number, price_category_id) VALUES (1, 1, 1, 1, 1);
INSERT INTO public.seats (id, hall_id, row_number, seat_number, price_category_id) VALUES (2, 1, 1, 2, 1);
INSERT INTO public.seats (id, hall_id, row_number, seat_number, price_category_id) VALUES (3, 2, 1, 1, 2);
