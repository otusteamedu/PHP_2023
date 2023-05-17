create table ticket
(
    id         integer     not null
        primary key,
    session_id integer     not null
        constraint fk_97a0ada3613fecdf
            references session,
    seat_id    integer     not null
        constraint fk_97a0ada3c1dafe35
            references seat,
    actual_cost       numeric(10) not null
);

create index idx_97a0ada3613fecdf
    on ticket (session_id);

create index idx_97a0ada3c1dafe35
    on ticket (seat_id);

