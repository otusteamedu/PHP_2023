create table hall
(
    id        integer      not null
        primary key,
    cinema_id integer      not null
        constraint fk_1b8fa83fb4cb84b6
            references cinema,
    name      varchar(255) not null
);
