create table attribute
(
    id      integer      not null
        primary key,
    type_id integer      not null
        constraint fk_fa7aeffbc54c8c93
            references attribute_type,
    name    varchar(255) not null
);

create index idx_fa7aeffbc54c8c93
    on attribute (type_id);