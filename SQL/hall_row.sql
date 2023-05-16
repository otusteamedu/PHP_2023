create table hall_row
(
    id       integer not null
        primary key,
    hall_id  integer not null
        constraint fk_8006466652afcfd6
            references hall,
    number   integer not null,
    capacity integer not null
);

create index idx_8006466652afcfd6
    on hall_row (hall_id);
