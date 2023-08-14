CREATE TYPE public.e_status AS ENUM ('Created', 'Processing', 'Finished');

CREATE TABLE public.task (
    id uuid NOT NULL DEFAULT uuid_generate_v4(),
    add_timestamp timestamp NOT NULL DEFAULT now()::timestamp without time zone,
    exec_timestamp timestamp NULL,
    finish_timestamp timestamp NULL,
    status public.e_status NOT NULL DEFAULT 'Created'::e_status,
    body text NULL,
    CONSTRAINT task_pk PRIMARY KEY (id)
);
CREATE INDEX task_add_timestamp_idx ON public.task USING btree (add_timestamp);
CREATE INDEX task_exec_timestamp_idx ON public.task USING btree (exec_timestamp);
CREATE INDEX task_finish_timestamp_idx ON public.task USING btree (finish_timestamp);
CREATE INDEX task_status_idx ON public.task USING btree (status);
