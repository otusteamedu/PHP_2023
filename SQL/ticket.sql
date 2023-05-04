-- auto-generated definition
create table ticket
(
    id         integer not null
        primary key,
    session_id integer not null
        constraint fk_97a0ada3613fecdf
            references session,
    client_id  integer not null
        constraint fk_97a0ada319eb6921
            references client,
    cost       integer not null
);

