create table session
(
    id        serial      not null
        primary key,
    cinema_id integer
        constraint fk_d044d5d4b4cb84b6
            references cinema,
    start     timestamp(0) not null
);

create index idx_d044d5d4b4cb84b6
    on session (cinema_id);