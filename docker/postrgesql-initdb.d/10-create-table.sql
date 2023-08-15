CREATE TABLE public.hall (
                             id uuid NOT NULL DEFAULT uuid_generate_v4(),
                             "name" varchar NULL, -- Наименование
                             seat int2 NOT NULL DEFAULT 0, -- Кол-во мест
                             active bool NOT NULL DEFAULT true,
                             CONSTRAINT hall_pkey PRIMARY KEY (id)
);
COMMENT ON COLUMN public.hall."name" IS 'Наименование';
COMMENT ON COLUMN public.hall.seat IS 'Кол-во мест';


CREATE TABLE public.movie (
                              id uuid NOT NULL DEFAULT uuid_generate_v4(),
                              "name" varchar NOT NULL, -- Наименование
                              release_date date NULL,
                              description text NULL, -- Описание
                              length_minute int2 NULL,
                              CONSTRAINT movie_pk PRIMARY KEY (id)
);
COMMENT ON COLUMN public.movie."name" IS 'Наименование';
COMMENT ON COLUMN public.movie.description IS 'Описание';


CREATE TABLE public.seat (
                             id uuid NOT NULL DEFAULT uuid_generate_v4(),
                             hall_id uuid NOT NULL,
                             "number" varchar(5) NOT NULL,
                             "row" varchar(5) NOT NULL,
                             active bool NOT NULL DEFAULT true,
                             type_id uuid NULL,
                             CONSTRAINT seat_pk PRIMARY KEY (id)
);


CREATE TABLE public."session" (
                                  id uuid NOT NULL DEFAULT uuid_generate_v4(),
                                  hall_id uuid NOT NULL,
                                  movie_id uuid NOT NULL,
                                  start_time timestamp NOT NULL,
                                  length_minute int2 NULL,
                                  CONSTRAINT session_pk PRIMARY KEY (id)
);


CREATE TABLE public.ticket (
                               id uuid NOT NULL DEFAULT uuid_generate_v4(),
                               session_id uuid NOT NULL,
                               seat_id uuid NOT NULL,
                               price numeric(10, 2) NOT NULL DEFAULT 0.0,
                               status int2 NULL DEFAULT 0, -- 0-доступен, 1-продан,2-забронирован,10-не доступен
                               CONSTRAINT ticket_pk PRIMARY KEY (id)
);
COMMENT ON COLUMN public.ticket.status IS '0-доступен, 1-продан,2-забронирован,10-не доступен';


CREATE TABLE public.seat_type (
                                  id uuid NOT NULL DEFAULT uuid_generate_v4(),
                                  "name" varchar NULL,
                                  CONSTRAINT seat_type_pk PRIMARY KEY (id)
);


CREATE TABLE public.price_catalog (
                                      id uuid NOT NULL DEFAULT uuid_generate_v4(),
                                      session_id uuid NULL,
                                      seat_type_id uuid NULL,
                                      price numeric(10, 2) NOT NULL DEFAULT 0.0,
                                      CONSTRAINT price_catalog_pk PRIMARY KEY (id)
);
