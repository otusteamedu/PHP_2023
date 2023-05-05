create table attribute
(
    id      integer      not null
        primary key,
    film_id integer      not null
        constraint fk_fa7aeffb567f5183
            references film,
    name    varchar(255) not null
);

create index idx_fa7aeffb567f5183
    on attribute (film_id);