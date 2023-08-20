create table if not exists post (
    id serial primary key,
    title varchar(100),
    content text,
    created_by varchar(100),
    created_at date
);
