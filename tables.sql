create table country
(
    id   smallint default nextval('code_seq'::regclass) not null
        constraint country_pk
            primary key,
    name varchar                                        not null
);

alter table country
    owner to ek;

create table genre
(
    id   smallint default nextval('code_seq2'::regclass) not null
        constraint genre_pk
            primary key,
    name varchar
);

comment on column genre.name is 'Название жанра';

alter table genre
    owner to ek;

create table movie
(
    id          integer default nextval('code_seq4'::regclass) not null
        constraint movie_pk
            primary key,
    name        varchar                                        not null,
    country     smallint                                       not null
        constraint movie_country_id_fk
            references country,
    genre       smallint                                       not null
        constraint movie_genre_id_fk
            references genre,
    time        smallint                                       not null,
    poster      varchar,
    description text,
    rating      smallint
);

comment on column movie.name is 'Название фильма';

comment on column movie.country is 'Страна';

comment on column movie.genre is 'Жанр';

comment on column movie.time is 'Время (мин)';

comment on column movie.poster is 'Ссылка на постер';

comment on column movie.description is 'Описние';

comment on column movie.rating is 'Рейтинг';

alter table movie
    owner to ek;

create table hall
(
    id   integer default nextval('code_seq3'::regclass) not null
        constraint hall_pk
            primary key,
    name varchar                                        not null,
    max  smallint                                       not null
);

comment on column hall.name is 'Название зала';

comment on column hall.max is 'Места';

alter table hall
    owner to ek;

create table seance
(
    id         integer default nextval('code_seq6'::regclass) not null
        constraint seance_pk
            primary key,
    start      timestamp                                      not null,
    hall_id    smallint                                       not null
        constraint seance_hall_id_fk
            references hall,
    movie_id   integer                                        not null
        constraint seance_movie_id_fk
            references movie,
    base_price integer                                        not null
);

comment on column seance.start is 'Начало';

comment on column seance.base_price is 'Базовая стоимость без наценки за место';

alter table seance
    owner to ek;

create table ticket
(
    id           integer default nextval('code_seq7'::regclass) not null
        constraint ticket_pk
            primary key,
    place        smallint                                       not null,
    row          integer,
    extra_charge integer,
    seance_id    integer
        constraint ticket_seance_id_fk
            references seance
);

comment on table ticket is 'Билеты';

comment on column ticket.place is 'место';

comment on column ticket.row is 'ряд';

comment on column ticket.extra_charge is 'Наценка за место';

alter table ticket
    owner to ek;

create table "order"
(
    id        integer default nextval('code_seq5'::regclass) not null
        constraint order_pk
            primary key,
    booking   boolean,
    paid      boolean                                        not null,
    cost      integer                                        not null,
    date_pay  timestamp,
    ticket_id integer
        constraint order_ticket_id_fk
            references ticket,
    movie_id  integer                                        not null
        constraint order_movie_id_fk
            references movie
);

comment on column "order".booking is 'Бронь';

comment on column "order".paid is 'оплачен';

comment on column "order".cost is 'Стоимость';

comment on column "order".date_pay is 'Дата и время оплаты';

alter table "order"
    owner to ek;