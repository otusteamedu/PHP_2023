create table attribute
(
    id                serial
        constraint attribute_pk
            primary key,
    name              varchar(40) not null,
    attribute_type_id integer
        constraint attribute_attribute_type_id_fk
            references attribute_type
);

alter table attribute
    owner to ek;


create table attribute_type
(
    id   integer default nextval('attribyte_type_id_seq'::regclass) not null
        constraint attribyte_type_pk
            primary key,
    name varchar(20)                                                not null
);

alter table attribute_type
    owner to ek;


create table value
(
    id           serial
        constraint value_pk
            primary key,
    value        varchar,
    movie_id     integer
        constraint value_movie_id_fk
            references movie,
    attribute_id integer
        constraint value_attribute_id_fk
            references attribute
);

comment on column value.value is 'Значение атрибута';

alter table value
    owner to ek;