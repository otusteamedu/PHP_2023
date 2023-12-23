create table prices
(
    id          serial
        primary key,
    category_id integer        not null
        constraint fk_price_category
            references price_categories,
    amount      numeric(10, 2) not null
);

alter table prices
    owner to postgres;

INSERT INTO public.prices (id, category_id, amount) VALUES (1, 1, 10.00);
INSERT INTO public.prices (id, category_id, amount) VALUES (2, 2, 15.00);
