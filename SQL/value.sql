create table value
(
    id           integer      not null
        primary key,
    attribute_id integer      not null
        constraint fk_1d775834b6e62efa
            references attribute,
    value        varchar(255) not null,
    type         varchar(255) not null
);

comment on column value.type is 'Типы значений datetime|bool|int|float|text|list';

create index idx_1d775834b6e62efa
    on value (attribute_id);