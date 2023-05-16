create table session
(
    id        integer      not null
        primary key,
    cinema_id integer
        constraint fk_d044d5d4b4cb84b6
            references cinema,
    hall_id   integer      not null
        constraint fk_d044d5d452afcfd6
            references hall,
    start     timestamp(0) not null
);

create index idx_d044d5d4b4cb84b6
    on session (cinema_id);

create index idx_d044d5d452afcfd6
    on session (hall_id);