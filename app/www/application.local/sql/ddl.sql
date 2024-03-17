CREATE TABLE news
(
    id         serial       not null
        constraint users_pkey
            primary key,
    title      varchar(255) not null,
    text       text         not null,
    image      varchar(255) not null,
    created_at timestamp    not null
);