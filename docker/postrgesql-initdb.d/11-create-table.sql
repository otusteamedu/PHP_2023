CREATE TABLE public.attributes_type (
                                        id uuid NOT NULL DEFAULT uuid_generate_v4(),
                                        "name" varchar NOT NULL,
                                        CONSTRAINT attributes_type_pk PRIMARY KEY (id)
);
CREATE INDEX attributes_type_name_idx ON public.attributes_type USING btree (name);


CREATE TABLE public.movie_attributes (
                                         id uuid NOT NULL DEFAULT uuid_generate_v4(),
                                         "name" varchar NOT NULL,
                                         type_id uuid NULL,
                                         parent_id uuid NULL,
                                         CONSTRAINT movie_attributes_pk PRIMARY KEY (id)
);
CREATE INDEX movie_attributes_name_idx ON public.movie_attributes USING btree (name);
CREATE INDEX movie_attributes_parent_id_idx ON public.movie_attributes USING btree (parent_id);


CREATE TABLE public.movie_attributes_value (
                                               id uuid NOT NULL DEFAULT uuid_generate_v4(),
                                               movie_id uuid NOT NULL,
                                               attribute_id uuid NOT NULL,
                                               value_string varchar NULL,
                                               value_bool bool NULL,
                                               value_date date NULL,
                                               value_float float NULL,
                                               active bool NULL DEFAULT true,
                                               CONSTRAINT movie_attributes_value_pk PRIMARY KEY (id)
);
CREATE INDEX movie_attributes_value_active_idx ON public.movie_attributes_value USING btree (active);
CREATE INDEX movie_attributes_value_attribute_id_idx ON public.movie_attributes_value USING btree (attribute_id);
CREATE INDEX movie_attributes_value_movie_id_idx ON public.movie_attributes_value USING btree (movie_id);
CREATE INDEX movie_attributes_value_value_string_idx ON public.movie_attributes_value USING btree (value_string);
CREATE INDEX movie_attributes_value_value_bool_idx ON public.movie_attributes_value USING btree (value_bool);
CREATE INDEX movie_attributes_value_value_date_idx ON public.movie_attributes_value USING btree (value_date);
CREATE INDEX movie_attributes_value_value_float_idx ON public.movie_attributes_value USING btree (value_float);
