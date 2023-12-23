create table session_price_categories
(
    session_id        integer not null
        constraint fk_session
            references sessions,
    price_category_id integer not null
        constraint fk_price_category
            references price_categories,
    primary key (session_id, price_category_id)
);

alter table session_price_categories
    owner to postgres;

INSERT INTO public.session_price_categories (session_id, price_category_id) VALUES (1, 1);
INSERT INTO public.session_price_categories (session_id, price_category_id) VALUES (2, 2);
