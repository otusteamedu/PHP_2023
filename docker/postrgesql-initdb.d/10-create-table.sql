CREATE TABLE public.hall (
                             id uuid NOT NULL DEFAULT uuid_generate_v4(),
                             "name" varchar NULL, -- Наименование
                             seat int2 NOT NULL DEFAULT 0, -- Кол-во мест
                             active bool NOT NULL DEFAULT true,
                             CONSTRAINT hall_pkey PRIMARY KEY (id)
);
CREATE INDEX hall_active_idx ON public.hall USING btree (active);
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
CREATE INDEX movie_name_idx ON public.movie USING btree (name);
CREATE INDEX movie_release_date_idx ON public.movie USING btree (release_date);
COMMENT ON COLUMN public.movie."name" IS 'Наименование';
COMMENT ON COLUMN public.movie.description IS 'Описание';


CREATE TABLE public.seat (
                             id uuid NOT NULL DEFAULT uuid_generate_v4(),
                             hall_id uuid NOT NULL,
                             "number" varchar(5) NOT NULL,
                             "row" varchar(5) NOT NULL,
                             active bool NOT NULL DEFAULT true,
                             CONSTRAINT seat_pk PRIMARY KEY (id)
);
CREATE INDEX seat_active_idx ON public.seat USING btree (active);
CREATE INDEX seat_hall_id_idx ON public.seat USING btree (hall_id);
CREATE INDEX seat_row_idx ON public.seat USING btree ("row", number);


CREATE TABLE public."session" (
                                  id uuid NOT NULL DEFAULT uuid_generate_v4(),
                                  hall_id uuid NOT NULL,
                                  movie_id uuid NOT NULL,
                                  start_time timestamp NOT NULL,
                                  length_minute int2 NULL,
                                  CONSTRAINT session_pk PRIMARY KEY (id)
);
CREATE INDEX session_hall_id_idx ON public.session USING btree (hall_id);
CREATE INDEX session_movie_id_idx ON public.session USING btree (movie_id);
CREATE INDEX session_start_time_idx ON public.session USING btree (start_time);


CREATE TABLE public.ticket (
                               id uuid NOT NULL DEFAULT uuid_generate_v4(),
                               session_id uuid NOT NULL,
                               seat_id uuid NOT NULL,
                               price numeric(10, 2) NOT NULL DEFAULT 0.0,
                               status int2 NULL DEFAULT 0, -- 0-доступен, 1-продан,2-забронирован,10-не доступен
                               CONSTRAINT ticket_pk PRIMARY KEY (id)
);
CREATE INDEX ticket_seat_id_idx ON public.ticket USING btree (seat_id);
CREATE INDEX ticket_session_id_idx ON public.ticket USING btree (session_id);
CREATE INDEX ticket_status_idx ON public.ticket USING btree (status);
COMMENT ON COLUMN public.ticket.status IS '0-доступен, 1-продан,2-забронирован,10-не доступен';