truncate table tickets cascade;
truncate table sessions cascade;
truncate table movies cascade;
truncate table halls cascade;
truncate table hall_schema cascade;

--залы
insert into halls (name, rows_count, seats_per_row)
values ('зал 1', 5, 6),
       ('зал 2', 5, 6),
       ('зал 3', 10, 15),
       ('зал 4', 10, 15),
       ('зал 5', 20, 20),
       ('зал 6', 25, 20),
       ('зал 7', 30, 20),
       ('зал 8', 30, 20);

--схемы залов
select generate_hall_schemas();
--100 фильмов
select generate_movies(100);
-- alter table sessions set unlogged;
-- alter table tickets set unlogged;

--1000 сеансов и 10000 билетов
select generate_sessions_tickets(
               1000,
               10000,
               timestamp '2023-04-10 00:00:00',
               timestamp '2023-12-31 00:00:00'
           );
select count(*) from sessions;
--100_000 сеансов и 1_000_000 билетов
select generate_sessions_tickets(
               1000000,
               10000000,
               timestamp '2023-04-10 00:00:00',
               timestamp '2027-12-31 00:00:00'
           );
