create table cinemas
(
    id      serial
        primary key,
    name    varchar(255) not null,
    address text         not null
);

alter table cinemas
    owner to postgres;

INSERT INTO public.cinemas (id, name, address) VALUES (1, 'Cinema Paradiso', '123 Main St');
INSERT INTO public.cinemas (id, name, address) VALUES (2, 'The Movie Palace', '456 Grand Ave');
