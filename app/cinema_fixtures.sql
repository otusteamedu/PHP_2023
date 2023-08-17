truncate table orders;
truncate table sessions;
truncate table movies;
truncate table halls;

insert into halls (number, seats_count)
values (1, 20),
       (2, 10),
       (3, 30),
       (4, 40),
       (5, 50);

insert into movies (name, duration)
values ('Алеша Попович и Тугарин Змей', '01:25:00'),
       ('Добрыня Никитич и Змей Горыныч', '01:30:54'),
       ('Илья Муромец и Соловей разбойник', '01:35:20'),
       ('Три богатыря на дальних берегах', '01:28:15'),
       ('Три богатыря и шамаханская царица', '01:37:51');

select id
from movies;
select id
from halls;

insert into sessions (movie_id, hall_id, begin_at)
values ('c4678d5d-1ecd-4d2b-91ed-d64e6881a75b', '55e33dc8-1153-4348-bced-8d72d6b237a8', now()),
       ('beafdfbc-f19c-4a0a-8413-c914c96be086', '059ce813-ad39-4168-b5f1-023a1006cacb', '2023-03-19 10:10:10'),
       ('bd8c2465-6517-4c34-838f-46d527ca9b09', '10bfcf7b-95a5-4a77-b3a1-5e8ac401c104', '2023-03-19 12:00:00'),
       ('7444583a-a028-4ae4-989d-bd8333cf08b5', '55f0a16f-94de-4ebf-bb89-10c9be0cb4f9', '2023-03-19 15:00:00'),
       ('a5ef2aa0-3850-4a0f-a274-238033464c1f', 'e02a3706-f079-4b12-ae7f-78d1fa769fa5', '2023-03-19 19:00:00');

select id
from sessions;

insert into orders (session_id, row, seat, price)
values ('3c497600-cf03-418e-8748-7cdbba26d2a0', 1, 2, 35000),
       ('84bc9ee4-2669-48d4-9848-5359eebe26f9', 2, 12, 25000),
       ('bb02105a-0f70-46a9-8250-d04aeb2a4de7', 3, 22, 20000),
       ('db0fab0f-d341-40dc-a2e4-9d46896504c6', 4, 32, 40000),
       ('db0fab0f-d341-40dc-a2e4-9d46896504c6', 4, 31, 40000),
       ('cad25efd-8fa4-4794-85a4-7434c06e9f61', 5, 42, 50000);
