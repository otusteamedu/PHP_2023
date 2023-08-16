CREATE TABLE public.attributes_type (
                                        id uuid NOT NULL DEFAULT uuid_generate_v4(),
                                        "name" varchar NOT NULL,
                                        CONSTRAINT attributes_type_pk PRIMARY KEY (id)
);


CREATE TABLE public.movie_attributes (
                                         id uuid NOT NULL DEFAULT uuid_generate_v4(),
                                         "name" varchar NOT NULL,
                                         type_id uuid NULL,
                                         parent_id uuid NULL,
                                         CONSTRAINT movie_attributes_pk PRIMARY KEY (id)
);


CREATE TABLE public.movie_attributes_value (
                                               id uuid NOT NULL DEFAULT uuid_generate_v4(),
                                               movie_id uuid NOT NULL,
                                               attribute_id uuid NOT NULL,
                                               value_string varchar NULL,
                                               value_bool bool NULL,
                                               value_date date NULL,
                                               value_float float NULL,
                                               value_int int NULL,
                                               active bool NULL DEFAULT true,
                                               CONSTRAINT movie_attributes_value_pk PRIMARY KEY (id)
);
