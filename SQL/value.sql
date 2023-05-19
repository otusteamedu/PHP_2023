create table value
(
    id           integer not null
        primary key,
    attribute_id integer not null
        constraint fk_1d775834b6e62efa
            references attribute,
    cinema_id    integer not null
        constraint fk_1d775834b4cb84b6
            references cinema,
    text         text,
    bool         boolean,
    date         timestamp(0) default NULL::timestamp without time zone,
    float        double precision,
    integer      integer
);

create index idx_1d775834b6e62efa
    on value (attribute_id);

create index idx_1d775834b4cb84b6
    on value (cinema_id);