create table ticket_price
(
    id           integer     not null
        primary key,
    session_id   integer     not null
        constraint fk_e2f84152613fecdf
            references session,
    seat_type_id integer     not null
        constraint fk_e2f841524ecee001
            references seat_type,
    price        numeric(10) not null
);

create index idx_e2f84152613fecdf
    on ticket_price (session_id);

create index idx_e2f841524ecee001
    on ticket_price (seat_type_id);
