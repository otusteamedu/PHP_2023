create table price_categories
(
    id          serial
        primary key,
    name        varchar(255) not null,
    description text
);

alter table price_categories
    owner to postgres;

INSERT INTO public.price_categories (id, name, description) VALUES (1, 'Standard', 'Standard seating price');
INSERT INTO public.price_categories (id, name, description) VALUES (2, 'Premium', 'Higher price for better seats');
