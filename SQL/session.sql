create table session
(
    id      integer      not null
        primary key,
    hall_id integer      not null
        constraint fk_d044d5d452afcfd6
            references hall,
    name    varchar(255) not null
);