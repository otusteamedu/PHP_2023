create table seat
(
    id      integer  not null
        primary key,
    row_id  integer  not null
        constraint fk_3d5c366683a269f2
            references hall_row,
    type_id integer  not null
        constraint fk_3d5c3666c54c8c93
            references seat_type,
    number  smallint not null
);

create index idx_3d5c366683a269f2
    on seat (row_id);

create index idx_3d5c3666c54c8c93
    on seat (type_id);
