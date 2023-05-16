create table ticket
(
    id         integer  not null
        primary key,
    session_id integer  not null
        constraint fk_97a0ada3613fecdf
            references session,
    row        smallint not null,
    cost       integer  not null,
    seat       smallint not null
);

create index idx_97a0ada3613fecdf
    on ticket (session_id);

